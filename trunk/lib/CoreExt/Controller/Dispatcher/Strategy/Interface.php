<?php

/**
 * i-Educar - Sistema de gest�o escolar
 *
 * Copyright (C) 2006  Prefeitura Municipal de Itaja�
 *                     <ctima@itajai.sc.gov.br>
 *
 * Este programa � software livre; voc� pode redistribu�-lo e/ou modific�-lo
 * sob os termos da Licen�a P�blica Geral GNU conforme publicada pela Free
 * Software Foundation; tanto a vers�o 2 da Licen�a, como (a seu crit�rio)
 * qualquer vers�o posterior.
 *
 * Este programa � distribu��do na expectativa de que seja �til, por�m, SEM
 * NENHUMA GARANTIA; nem mesmo a garantia impl��cita de COMERCIABILIDADE OU
 * ADEQUA��O A UMA FINALIDADE ESPEC�FICA. Consulte a Licen�a P�blica Geral
 * do GNU para mais detalhes.
 *
 * Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral do GNU junto
 * com este programa; se n�o, escreva para a Free Software Foundation, Inc., no
 * endere�o 59 Temple Street, Suite 330, Boston, MA 02111-1307 USA.
 *
 * @author    Eriksen Costa Paix�o <eriksen.paixao_bs@cobra.com.br>
 * @category  i-Educar
 * @license   @@license@@
 * @package   CoreExt_Controller
 * @since     Arquivo dispon�vel desde a vers�o 1.1.0
 * @version   $Id$
 */

/**
 * CoreExt_Controller_Dispatcher_Strategy_Interface interface.
 *
 * @author    Eriksen Costa Paix�o <eriksen.paixao_bs@cobra.com.br>
 * @category  i-Educar
 * @license   @@license@@
 * @package   CoreExt_Controller
 * @since     Interface dispon�vel desde a vers�o 1.1.0
 * @version   @@package_version@@
 */
interface CoreExt_Controller_Dispatcher_Strategy_Interface
{
  /**
   * Construtor.
   * @param CoreExt_Controller_Interface $controller
   */
  public function __construct(CoreExt_Controller_Interface $controller);

  /**
   * Setter para a inst�ncia de CoreExt_Controller_Interface.
   * @param CoreExt_Controller_Interface $controller
   * @return CoreExt_Controller_Strategy_Interface Prov� interface flu�da
   */
  public function setController(CoreExt_Controller_Interface $controller);

  /**
   * Getter.
   * @return CoreExt_Controller_Interface
   */
  public function getController();

  /**
   * Realiza o dispatch da requisi��o, encaminhando o controle da execu��o ao
   * controller adequado.
   *
   * @return bool
   * @throws Exception
   */
  public function dispatch();
}