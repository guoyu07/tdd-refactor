<?php
/**
 * Archive archive entity.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-19
 */
namespace Service\Archive\Request;

class ArchiveEntity {

    public function __construct($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
        $this->_row = $row;
    }

    protected function _buildTableName() {
        return 'request_archives_' . date('Ym', $this->ctime);
    }

    public function create() {
        $Model_Archive = new \Model_Archive();
        $Model_Archive->createTableIfNotExist($this->_buildTableName());
        $Model_Archive->insert($this->_buildTableName(), $this->_row);
    }
}