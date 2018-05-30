<?php
/*
* User Class
* This class is used for database related (connect, fetch, and insert) operations
*/
class Pagination{
    private $regs       = 1;
    private $regPerPage = 8;
    private $pages      = 1;
    private $page       = 1;

    public function __construct($regs, $regPerPage = 8){
        $this->regs = $regs;
        $this->$regPerPage = $regPerPage;
        $this->pages = ceil($this->regs/$this->$regPerPage);

        $this->page = min($this->pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));
    }

    public function getLastPage() {
        return $this->pages;
    }

    public function nextPage() {
        $this->page += $this->getNextPage();
    }

    public function getNextPage() {
        if ( ($this->page + 1) <= $this->getLastPage()) {
            return $this->page + 1;
        }

        return $this->getLastPage();
    }

    public function prevPage() {
        $this->page = $this->getPrevPage();
    }

    public function getPrevPage() {
        if ( ($this->page - 1) >= 1) {
            return $this->page - 1;
        }

        return 1;
    }

    public function getPageNow() {
        return $this->page;
    }

    public function getOffsets() {
        // Some information to display to the user
        $offsets['start'] = ($this->page - 1)  * $this->regPerPage;
        $offsets['limit'] = $this->regPerPage;
        return $offsets;
    }

    public function print() {

        echo <<<HTML
        <nav>
            <ul class="pagination pagination-sm justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="?page=1"><<</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page={$this->getPrevPage()}"><</a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="?page={$this->getNextPage()}" >></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page={$this->getLastPage()}">>></a>
                </li>
            </ul>
            <small id="emailHelp" class="form-text text-muted text-right">Page {$this->getPageNow()}/{$this->getLastPage()}</small>

        </nav>
HTML;

    }

}
