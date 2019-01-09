<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 05/01/2019
 * Time: 00:13
 */

require_once("Geral.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR TUDO REFERENTE AS TRANSAÇÕES DE ESTOQUE.
*/
class Estoque extends Geral
{
    public function __construct()
    {
        parent::__construct();

        if (empty($this->Account_model->session_is_valid()['id'])) {
            $url_redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $url_redirect = str_replace("/", "-x", $url_redirect);
            redirect('account/login/' . $url_redirect);
        }

        $this->load->model('Peca_model');

        $this->load->model('Transacao_model');
        $this->load->model('Estoque_model');
        $this->load->model('Fornecedor_model');

        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS AS PEÇAS CADASTRADAS E ENVIA-LAS A VIEW.
    *
    *	$page -> Número da página atual de registros.
    */
    public function index($page = FALSE, $field = FALSE, $order = FALSE)
    {
        if ($page === FALSE)
            $page = 1;

        $ordenacao = array(
            "order" => $this->order_default($order),
            "field" => $this->field_default($field, "Estoque_id")
        );

        $this->set_page_cookie($page);

        $this->data['title'] = 'Estoque';
        if ($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE) {
            $this->data['paginacao']['order'] = $this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];

            $this->data['estoque'] = $this->Estoque_model->get_estoque(FALSE, FALSE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['estoque']) ? $this->data['estoque'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("estoque/index", $this->data);
        } else
            $this->view("templates/permissao", $this->data);
    }
}