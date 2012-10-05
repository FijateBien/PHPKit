
<?php

/**
 * class mysql_table
 * 
 */
class mysql_list_view {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * 
     * @access private
     */
    private $name = "";

    /**
     * 
     * @access private
     */
    private $columns = 3;

    /**
     * 
     * @access private
     */
    private $per_page = 10;

    /**
     * 
     * @access private
     */
    private $primary_label;

    /**
     * 
     * @access public
     */
    public $res;

    /**
     * 
     * @param mysql_command resource
     * 
     * @param string name
     * 
     * @param int columns
     * 
     * @param int per_page
     * 
     * @param string primary_label
     * 
     * @access public
     */
    public function __construct($resource, $name, $columns, $per_page, $primary_label) {
        $this->name = $name;
        $this->res = $resource;
        $this->columns = $columns;
        $this->per_page = $per_page;
        $this->primary_label = $primary_label;
    }

    /**
     * 
     * @access public
     */
    public function generate_list_view() {
        echo( "----------gola ------------");

        $list_view = "<div class='mysql_list_view' id='$this->name'>";

        echo( " ----------- Entered ----------" );

        $this->res->exec("SELECT * from $this->name;");

        $list = $this->res->fetch();

        $list_item_width = round(100 / $this->columns);

        foreach ($list As $list_view_item)
            $list_view.= "\n <div 	class='mysql_list_view_item' 
								style='float:left; width: $list_item_width%;'>" .
                    eval("echo \$list_view_item->$this->primary_label;")
                    . "</div>";
        $list_view.= "</div>";
        echo $list_view;
    }

}

// end of mysql_list_view
?>
