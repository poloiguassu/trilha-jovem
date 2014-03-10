<?php

/**
 * i-Educar - Sistema de gestão escolar
 *
 * Copyright (C) 2006  Prefeitura Municipal de Itajaí
 *                     <ctima@itajai.sc.gov.br>
 *
 * Este programa é software livre; você pode redistribuí-lo e/ou modificá-lo
 * sob os termos da Licença Pública Geral GNU conforme publicada pela Free
 * Software Foundation; tanto a versão 2 da Licença, como (a seu critério)
 * qualquer versão posterior.
 *
 * Este programa é distribuí­do na expectativa de que seja útil, porém, SEM
 * NENHUMA GARANTIA; nem mesmo a garantia implí­cita de COMERCIABILIDADE OU
 * ADEQUAÇÃO A UMA FINALIDADE ESPECÍFICA. Consulte a Licença Pública Geral
 * do GNU para mais detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral do GNU junto
 * com este programa; se não, escreva para a Free Software Foundation, Inc., no
 * endereço 59 Temple Street, Suite 330, Boston, MA 02111-1307 USA.
 *
 * @author      Eriksen Costa Paixão <eriksen.paixao_bs@cobra.com.br>
 * @category    i-Educar
 * @license     @@license@@
 * @package     ComponenteCurricular
 * @subpackage  Modules
 * @since       Arquivo disponível desde a versão 1.1.0
 * @version     $Id$
 */

require_once 'Core/Controller/Page/ViewController.php';
require_once 'ComponenteCurricular/Model/ComponenteDataMapper.php';

/**
 * ViewController class.
 *
 * @author      Eriksen Costa Paixão <eriksen.paixao_bs@cobra.com.br>
 * @category    i-Educar
 * @license     @@license@@
 * @package     ComponenteCurricular
 * @subpackage  Modules
 * @since       Classe disponível desde a versão 1.1.0
 * @version     @@package_version@@
 */
class ViewController extends Core_Controller_Page_ViewController
{
  protected $_dataMapper = 'ComponenteCurricular_Model_ComponenteDataMapper';
  protected $_titulo     = 'Detalhes de área de conhecimento';
  protected $_processoAp = 946;
  protected $_tableMap   = array(
    'Nome' => 'nome',
    'Abreviatura' => 'abreviatura',
    'Base curricular' => 'tipo_base',
    'Área conhecimento' => 'area_conhecimento'
  );

  /**
   * Construtor.
   */
  public function __construct()
  {
    $this->addBotao('Configurar Cargo Horária', 'ano?cid=' . $_GET['id']);
         //->addBotao('Configurar descritores', 'descritores?cid=' . $_GET['id']);
  }
}