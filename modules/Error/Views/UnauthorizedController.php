<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * i-Educar - Sistema de gestÃ£o escolar
 *
 * Copyright (C) 2006  Prefeitura Municipal de ItajaÃ­
 *     <ctima@itajai.sc.gov.br>
 *
 * Este programa Ã© software livre; vocÃª pode redistribuÃ­-lo e/ou modificÃ¡-lo
 * sob os termos da LicenÃ§a PÃºblica Geral GNU conforme publicada pela Free
 * Software Foundation; tanto a versÃ£o 2 da LicenÃ§a, como (a seu critÃ©rio)
 * qualquer versÃ£o posterior.
 *
 * Este programa Ã© distribuÃ­Â­do na expectativa de que seja Ãºtil, porÃ©m, SEM
 * NENHUMA GARANTIA; nem mesmo a garantia implÃ­Â­cita de COMERCIABILIDADE OU
 * ADEQUAÃ‡ÃƒO A UMA FINALIDADE ESPECÃFICA. Consulte a LicenÃ§a PÃºblica Geral
 * do GNU para mais detalhes.
 *
 * VocÃª deve ter recebido uma cÃ³pia da LicenÃ§a PÃºblica Geral do GNU junto
 * com este programa; se nÃ£o, escreva para a Free Software Foundation, Inc., no
 * endereÃ§o 59 Temple Street, Suite 330, Boston, MA 02111-1307 USA.
 *
 * @author    Lucas D'Avila <lucasdavila@portabilis.com.br>
 * @category  i-Educar
 * @license   @@license@@
 * @package   Portabilis
 * @subpackage  lib
 * @since   Arquivo disponÃ­vel desde a versÃ£o ?
 * @version   $Id$
 */

require_once 'Portabilis/Controller/ErrorCoreController.php';

class UnauthorizedController extends Portabilis_Controller_ErrorCoreController
{
  protected $_titulo = 'Acesso não autorizado';

  protected function setHeader() {
    header("HTTP/1.1 403 Forbidden");
  }

  public function Gerar() {
    $linkToSupport = $GLOBALS['coreExt']['Config']->modules->error->link_to_support;

    echo "
      <div id='error' class='small'>
        <div class='content'>
         <h1>Acesso n&atilde;o autorizado</h1>

         <p class='explanation'>
          Seu usuário não possui autorização para realizar está ação,
          <strong> tente seguir as etapas abaixo:</strong>

          <ol>
            <li><a href='/intranet/index.php'>Volte para o sistema</a></li>
            <li>Solicite ao responsável pelo sistema, para adicionar ao seu usuário a permissão necessária e tente novamente</li>
            <li>Caso o erro persista, por favor, <a target='_blank' href='$linkToSupport'>solicite suporte</a>.</li>
          </ol>
        </p>

        </div>
      </div>";
  }
}
