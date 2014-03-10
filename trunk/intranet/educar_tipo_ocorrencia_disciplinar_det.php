<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	*																	     *
	*	@author Prefeitura Municipal de Itajaí								 *
	*	@updated 29/03/2007													 *
	*   Pacote: i-PLB Software Público Livre e Brasileiro					 *
	*																		 *
	*	Copyright (C) 2006	PMI - Prefeitura Municipal de Itajaí			 *
	*						ctima@itajai.sc.gov.br					    	 *
	*																		 *
	*	Este  programa  é  software livre, você pode redistribuí-lo e/ou	 *
	*	modificá-lo sob os termos da Licença Pública Geral GNU, conforme	 *
	*	publicada pela Free  Software  Foundation,  tanto  a versão 2 da	 *
	*	Licença   como  (a  seu  critério)  qualquer  versão  mais  nova.	 *
	*																		 *
	*	Este programa  é distribuído na expectativa de ser útil, mas SEM	 *
	*	QUALQUER GARANTIA. Sem mesmo a garantia implícita de COMERCIALI-	 *
	*	ZAÇÃO  ou  de ADEQUAÇÃO A QUALQUER PROPÓSITO EM PARTICULAR. Con-	 *
	*	sulte  a  Licença  Pública  Geral  GNU para obter mais detalhes.	 *
	*																		 *
	*	Você  deve  ter  recebido uma cópia da Licença Pública Geral GNU	 *
	*	junto  com  este  programa. Se não, escreva para a Free Software	 *
	*	Foundation,  Inc.,  59  Temple  Place,  Suite  330,  Boston,  MA	 *
	*	02111-1307, USA.													 *
	*																		 *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
require_once ("include/clsBase.inc.php");
require_once ("include/clsDetalhe.inc.php");
require_once ("include/clsBanco.inc.php");
require_once( "include/pmieducar/geral.inc.php" );

class clsIndexBase extends clsBase
{
	function Formular()
	{
		$this->SetTitulo( "{$this->_instituicao} Trilha Jovem - Tipo Ocorrência Disciplinar" );
		$this->processoAp = "580";
	}
}

class indice extends clsDetalhe
{
	/**
	 * Titulo no topo da pagina
	 *
	 * @var int
	 */
	var $titulo;

	var $cod_tipo_ocorrencia_disciplinar;
	var $ref_usuario_exc;
	var $ref_usuario_cad;
	var $nm_tipo;
	var $descricao;
	var $max_ocorrencias;
	var $data_cadastro;
	var $data_exclusao;
	var $ativo;
	var $ref_cod_instituicao;

	function Gerar()
	{
		@session_start();
		$this->pessoa_logada = $_SESSION['id_pessoa'];
		session_write_close();

		$this->titulo = "Tipo Ocorrência Disciplinar - Detalhe";
		$this->addBanner( "imagens/nvp_top_intranet.jpg", "imagens/nvp_vert_intranet.jpg", "Intranet" );

		$this->cod_tipo_ocorrencia_disciplinar=$_GET["cod_tipo_ocorrencia_disciplinar"];

		$tmp_obj = new clsPmieducarTipoOcorrenciaDisciplinar( $this->cod_tipo_ocorrencia_disciplinar );
		$registro = $tmp_obj->detalhe();

		if( ! $registro )
		{
			header( "location: educar_tipo_ocorrencia_disciplinar_lst.php" );
			die();
		}


		if (class_exists("clsPmieducarInstituicao"))
		{
			$obj_instituicao = new clsPmieducarInstituicao($registro["ref_cod_instituicao"]);
			$obj_instituicao_det = $obj_instituicao->detalhe();
			$registro["ref_cod_instituicao"] = $obj_instituicao_det['nm_instituicao'];
		}
		else
		{
			$cod_instituicao = "Erro na geração";
			echo "<!--\nErro\nClasse não existente: clsPmieducarInstituicao\n-->";
		}

		$obj_permissao = new clsPermissoes();
		$nivel_usuario = $obj_permissao->nivel_acesso($this->pessoa_logada);
		if ($nivel_usuario == 1)
		{
			if( $registro["ref_cod_instituicao"] )
			{
				$this->addDetalhe( array( "Instituição", "{$registro["ref_cod_instituicao"]}") );
			}
		}
		if( $registro["nm_tipo"] )
		{
			$this->addDetalhe( array( "Tipo Ocorrência Disciplinar", "{$registro["nm_tipo"]}") );
		}
		if( $registro["descricao"] )
		{
			$this->addDetalhe( array( "Descrição", "{$registro["descricao"]}") );
		}
		if( $registro["max_ocorrencias"] )
		{
			$this->addDetalhe( array( "Máximo de Ocorrências", "{$registro["max_ocorrencias"]}") );
		}

		if( $obj_permissao->permissao_cadastra( 580, $this->pessoa_logada,3 ) )
		{
			$this->url_novo = "educar_tipo_ocorrencia_disciplinar_cad.php";
			$this->url_editar = "educar_tipo_ocorrencia_disciplinar_cad.php?cod_tipo_ocorrencia_disciplinar={$registro["cod_tipo_ocorrencia_disciplinar"]}";
		}
		$this->url_cancelar = "educar_tipo_ocorrencia_disciplinar_lst.php";
		$this->largura = "100%";
	}
}

// cria uma extensao da classe base
$pagina = new clsIndexBase();
// cria o conteudo
$miolo = new indice();
// adiciona o conteudo na clsBase
$pagina->addForm( $miolo );
// gera o html
$pagina->MakeAll();
?>