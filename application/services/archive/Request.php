<?php
/**
 * Archive request service.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-03-22
 */
namespace Service\Archive;

use Service\Archive\Request\Handler;

class Request {

    protected $_limit = 0;

    protected $_archive_time = 0;
    
    public function setLimit($limit) {
        $this->_limit = $limit;
    }

    public function setPassDays($days) {
        $this->_archive_time = (time() - 86400 * $days);
    }

    public function archive() {
        $Model    = new \Core\Model\Medoo();
        $requests = $Model->medoo()
            ->query("SELECT * FROM request WHERE ctime < {$this->_archive_time} ORDER BY ctime ASC LIMIT {$this->_limit}")
            ->fetchAll(\PDO::FETCH_ASSOC);

        if ( empty($requests) ) return;

        foreach ($requests as $request) {
            $request['archive_time'] = time();
            (new Handler())->archive($request);
        }
    }
}