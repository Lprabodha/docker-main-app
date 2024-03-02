<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;

class Staticblock extends Controller
{

    public function index()
    {
        Authentication::guard();

        $view = new \Altum\Views\View('staticblock/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function delete()
    {

        Authentication::guard();

        /* Team checks */
        if (\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('delete')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('staticblocks');
        }

        if (empty($_POST)) {
            redirect('staticblocks');
        }

        $staticblock_id = (int) Database::clean_string($_POST['staticblock_id']);

        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

        if (!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if (!$staticblock = db()->where('staticblock_id', $staticblock_id)->where('user_id', $this->user->user_id)->getOne('staticblocks', ['staticblock_id', 'name'])) {
            redirect('staticblocks');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* Delete the staticblock */
            db()->where('staticblock_id', $staticblock_id)->delete('staticblocks');

            /* Set a nice success message */
            Alerts::add_success(sprintf(l('global.success_message.delete1'), '<strong>' . $staticblock->name . '</strong>'));

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItem('staticblocks?user_id=' . $this->user->user_id);

            redirect('staticblocks');
        }

        redirect('staticblocks');
    }
}
