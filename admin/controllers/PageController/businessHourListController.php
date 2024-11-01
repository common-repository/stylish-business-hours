<?php

class DF_SBH_BusinessHourListController extends \WP_List_Table
{
    function __construct()
    {
        parent::__construct(array(
            'singular' => 'List',
            'plural' => 'Lists',
            'ajax' => false
        ));
        $allowed_action_params = array(
            'delete',
            'list',
        );
        $action_param_index = isset( $_REQUEST['action'] ) ? array_search( $_REQUEST['action'], $allowed_action_params ) : null;
        $action             = ! is_null( $action_param_index ) ? $allowed_action_params[ $action_param_index ] : 'list';
        $id  = isset($_REQUEST['id']) ? sanitize_text_field( $_REQUEST['id'] ) : 0;

        switch ($action) {
            case 'delete':
                $ids = isset($_REQUEST['ids']) ? sanitize_text_or_array_field( $_REQUEST['ids'] ) : null;
                if (!empty($ids)) {
                    foreach ($ids as $key => $id) {
                        $this->sbh_delete_tabs_by_id($id);
                    }
                } else if (!empty($_REQUEST['id']) && wp_verify_nonce($_REQUEST['nonce'], 'delete_sbh')) {
                    $id = $_REQUEST['id'];
                    $this->sbh_delete_tabs_by_id($id);
                }
            default:
                $template = dirname(__FILE__) . '/views/tabs-list.php';
                break;
        }
        $this->render();
    }

    function sbh_get_all_tabs()
    {
        require_once dirname(__FILE__, 2) . '/dataController.php';
        $dc = new DF_SBH_DataController();
        return $dc->read();
    }
    // echo json_encode($this->get_data);
    function sbh_delete_tabs_by_id($id)
    {
        require_once dirname(__FILE__, 2) . '/dataController.php';
        $dc = new DF_SBH_DataController();
        $dc->delete($id);
    }
    function sbh_get_tabs_count()
    {
        return count($this->sbh_get_all_tabs());
    }

    function get_table_classes()
    {
        return array(
            'widefat',
            'fixed',
            'striped',
            $this->_args['plural']
        );
    }

    function no_items()
    {
        esc_attr_e('No Lists Found', 'sbh');
    }


    function column_default($item, $column_name)
    {

        switch ($column_name) {
            case 'id':
                return $item->id;

            case 'list_name':
                return $item->list_name;

            case 'shortcode':
                return $item->shortcode;
            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => __('List Name', 'sbh'),
            'shortcode' => __('Shortcode', 'sbh')
        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_id($item)
    {

        $actions           = array();
        $actions['edit']   = sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=business_hour_page_new&action=edit&id=' . $item->id), $item->id, __('Edit this item', 'sbh'), __('Edit', 'sbh'));
        $actions['delete'] = sprintf('<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=business_hour_listing&action=delete&id=' . $item->id . '&nonce=' . wp_create_nonce('delete_sbh')), $item->id, __('Delete this item', 'sbh'), __('Delete', 'sbh'));

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=business_hour_page_new&action=edit&id=' . $item->id), $item->list_name, $this->row_actions($actions));
    }

    function column_refer($item)
    {
        return sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=business_hour_page_new&action=readonly&id=' . $item->id), $item->id, __('#' . $item->id, 'c9s'), __('#' . $item->id, 'c9s'));
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array(
                'name',
                true
            )
        );

        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => __('Delete Selected Items', 'sbh')
        );
        return $actions;
    }


    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="ids[]" value="%s" />', $item->id);
    }

    public function get_views_()
    {
        $status_links = array();
        $base_link    = admin_url('admin.php?page=sample-page');

        foreach ($this->counts as $key => $value) {
            $class              = ($key == $this->page_status) ? 'current' : 'status-' . $key;
            $status_links[$key] = sprintf('<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg(array(
                'status' => $key
            ), $base_link), $class, $value['label'], $value['count']);
        }

        return $status_links;
    }


    function prepare_items()
    {

        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array(
            $columns,
            $hidden,
            $sortable
        );

        $per_page          = 20;
        $current_page      = $this->get_pagenum();
        $offset            = ($current_page - 1) * $per_page;
        $this->page_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '2';
        $search            = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
            'search' => '*' . $search . '*'
        );

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = sanitize_text_field( $_REQUEST['orderby'] );
            $args['order']   = sanitize_text_field( $_REQUEST['order'] );
        }

        $this->items = $this->sbh_get_all_tabs($args);

        $this->set_pagination_args(array(
            'total_items' => $this->sbh_get_tabs_count(),
            'per_page' => $per_page
        ));
    }

    function render()
    {
?>
        <div class="wrap">
            <?php $this->get_header() ?>
            <h5><?php esc_attr_e('Business Hour Plugin List', 'sbl'); ?> <a href="<?php echo esc_url( admin_url('admin.php?page=business_hour_page_new') ); ?>" class="add-new-h2"><?php esc_attr_e('Add New', 'sbh'); ?></a></h5>
            <form method="post">
                <input type="hidden" name="page" value="ttest_list_table">
                <?php
                if ( ! is_object( $this->sbh_get_all_tabs() ) ) {
                    $this->prepare_items();
                }
                $this->search_box('search', 's');
                $this->display();
                ?>
            </form>
        </div>
<?php
        $this->get_footer();
    }
    function get_header()
    {
        require_once dirname(__FILE__, 3) . '/view/logo-header.php';
    }
    function get_footer()
    {
        require_once dirname(__FILE__, 3) . '/view/logo-footer.php';
    }
}
new DF_SBH_BusinessHourListController();
