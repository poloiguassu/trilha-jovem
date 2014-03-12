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
require_once ("include/clsListagem.inc.php");
require_once ("include/clsBanco.inc.php");
require_once( "include/pmieducar/geral.inc.php" );
require_once ("include/localizacaoSistema.php");

class clsIndexBase extends clsBase
{
	function Formular()
	{
		$this->SetTitulo( "{$this->_instituicao} Trilha Jovem - Função Cômodo" );
		$this->processoAp = "572";
                $this->addEstilo( "localizacaoSistema" );
	}
}

class indice extends clsListagem
{
	/**
	 * Referencia pega da session para o idpes do usuario atual
	 *
	 * @var int
	 */
	var $pessoa_logada;

	/**
	 * Titulo no topo da pagina
	 *
	 * @var int
	 */
	var $titulo;

	/**
	 * Quantidade de registros a ser apresentada em cada pagina
	 *
	 * @var int
	 */
	var $limite;

	/**
	 * Inicio dos registros a serem exibidos (limit)
	 *
	 * @var int
	 */
	var $offset;

	var $cod_infra_comodo_funcao;
	var $ref_usuario_exc;
	var $ref_usuario_cad;
	var $nm_funcao;
	var $desc_funcao;
	var $data_cadastro;
	var $data_exclusao;
	var $ativo;
	var $ref_cod_instituicao;
	var $ref_cod_escola;

	function Gerar()
	{
		@session_start();
		$this->pessoa_logada = $_SESSION['id_pessoa'];
		session_write_close();

		$this->titulo = "Funçao Cômodo - Listagem";

		foreach( $_GET AS $var => $val ) // passa todos os valores obtidos no GET para atributos do objeto
			$this->$var = ( $val === "" ) ? null: $val;

		$this->addBanner( "imagens/nvp_top_intranet.jpg", "imagens/nvp_vert_intranet.jpg", "Intranet" );

		$lista_busca = array(
			"Função Cômodo"
		);

		$obj_permissao = new clsPermissoes();
		$nivel_usuario = $obj_permissao->nivel_acesso($this->pessoa_logada);
		if ($nivel_usuario == 1)
		{
			$lista_busca[] = "Instituição";
			$lista_busca[] = "Instituição Executora";
		}
		else if ($nivel_usuario == 2)
		{
			$lista_busca[] = "Instituição";
		}
		$this->addCabecalhos($lista_busca);

		$get_escola = true;
		include("include/pmieducar/educar_campo_lista.php");

		// outros Filtros
		$this->campoTexto( "nm_funcao", "Função", $this->nm_funcao, 30, 255, false );


		// Paginador
		$this->limite = 20;
		$this->offset = ( $_GET["pagina_{$this->nome}"] ) ? $_GET["pagina_{$this->nome}"]*$this->limite-$this->limite: 0;

		$obj_infra_comodo_funcao = new clsPmieducarInfraComodoFuncao();
		$obj_infra_comodo_funcao->setOrderby( "nm_funcao ASC" );
		$obj_infra_comodo_funcao->setLimite( $this->limite, $this->offset );

		$lista = $obj_infra_comodo_funcao->lista(
			$this->cod_infra_comodo_funcao,
			null,
			null,
			$this->nm_funcao,
			null,
			null,
			null,
			null,
			null,
			1,
			$this->ref_cod_escola,
			$this->ref_cod_instituicao
		);

		$total = $obj_infra_comodo_funcao->_total;

		// monta a lista
		if( is_array( $lista ) && count( $lista ) )
		{
			foreach ( $lista AS $registro )
			{
				if( class_exists( "clsPmieducarEscola" ) )
				{
					$obj_ref_cod_escola = new clsPmieducarEscola( $registro["ref_cod_escola"] );
					$det_ref_cod_escola = $obj_ref_cod_escola->detalhe();
					$nm_escola = $det_ref_cod_escola["nome"];
				}
				else
				{
					$registro["ref_cod_escola"] = "Erro na geração";
					echo "<!--\nErro\nClasse não existente: clsPmieducarEscola\n-->";
				}
				if( class_exists( "clsPmieducarInstituicao" ) )
				{
					$obj_ref_cod_instituicao = new clsPmieducarInstituicao( $registro["ref_cod_instituicao"] );
					$det_ref_cod_instituicao = $obj_ref_cod_instituicao->detalhe();
					$registro["ref_cod_instituicao"] = $det_ref_cod_instituicao["nm_instituicao"];
				}
				else
				{
					$registro["ref_cod_escola"] = "Erro na geração";
					echo "<!--\nErro\nClasse não existente: clsPmieducarEscola\n-->";
				}

				$lista_busca = array(
					"<a href=\"educar_infra_comodo_funcao_det.php?cod_infra_comodo_funcao={$registro["cod_infra_comodo_funcao"]}\">{$registro["nm_funcao"]}</a>"
				);

				if ($nivel_usuario == 1)
				{
					$lista_busca[] = "<a href=\"educar_infra_comodo_funcao_det.php?cod_infra_comodo_funcao={$registro["cod_infra_comodo_funcao"]}\">{$nm_escola}</a>";
					$lista_busca[] = "<a href=\"educar_infra_comodo_funcao_det.php?cod_infra_comodo_funcao={$registro["cod_infra_comodo_funcao"]}\">{$registro["ref_cod_instituicao"]}</a>";
				}
				else if ($nivel_usuario == 2)
				{
					$lista_busca[] = "<a href=\"educar_infra_comodo_funcao_det.php?cod_infra_comodo_funcao={$registro["cod_infra_comodo_funcao"]}\">{$nm_escola}</a>";
				}
				$this->addLinhas($lista_busca);
			}
		}
		$this->addPaginador2( "educar_infra_comodo_funcao_lst.php", $total, $_GET, $this->nome, $this->limite );


		$obj_permissao = new clsPermissoes();
		if($obj_permissao->permissao_cadastra(567, $this->pessoa_logada,7))
		{
			$this->acao = "go(\"educar_infra_comodo_funcao_cad.php\")";
			$this->nome_acao = "Novo";;
		}

		$this->largura = "100%";
                
                $localizacao = new LocalizacaoSistema();
                $localizacao->entradaCaminhos( array(
                    $_SERVER['SERVER_NAME']."/intranet" => "Trilha Jovem",
                    "educar_index.php"                  => "Instituição",
                    ""                                  => "Listagem de Função Cômodo"
                ));
                $this->enviaLocalizacao($localizacao->montar());
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