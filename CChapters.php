<?php

require_once '../db_cfg.php';
require_once 'config.php';

// Object class to wrap access to the Chapters DB
class CChapters
{

  // Class members
  private $_db = NULL;

  // Initialize Class
  function init()
  {
    $this->_db = db_connect();

    if (isset($this->_db))
      return true;
    else
      return false;
  }

  // TODO: Implement Access Control

  function getChapterLive()
  {
    if (!isset($this->_db)) return NULL;

    $criteria = "mediaid = 0 AND posted = 1";

    $sort = "date DESC";

    $limit = 1;

    return $this->_db_getChapters($criteria, $sort, $limit);
  }

  function findChapter($mediaid, $time_offset)
  {
    if (!isset($this->_db)) return NULL;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_time_offset = $this->_db->quoteSmart($time_offset);

    $criteria = "mediaid = $db_mediaid AND offset <= $db_time_offset AND posted=1";

    $sort = "offset DESC";

    $limit = 1;

    return $this->_db_getChapters($criteria, $sort, $limit);
  }

  function getChapterList($mediaid, $posted = NULL)
  {
    if (!isset($this->_db)) return NULL;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $criteria = "mediaid=$db_mediaid";

    if (isset($posted)) {
      $db_posted = $this->_db->quoteSmart($posted);
      $criteria .= " AND posted = $db_posted";
    }

    $sort = "posted DESC, offset ASC, date ASC";

    return $this->_db_getChapters($criteria, $sort);
  }

  function _db_getChapters($criteria = NULL, $sort = NULL, $limit = NULL)
  {
    if (!isset($this->_db)) return false;

    $sql = 'SELECT id, mediaid, name, offset, posted FROM agenda_items WHERE NOT deleted AND broadcasterid=' . $this->_db->quoteSmart(PFS_BROADCASTERID);

    if (isset($criteria) && !empty($criteria))
      $sql .= ' AND ' . $criteria;

    if (isset($sort) && !empty($sort))
      $sql .= ' ORDER BY ' . $sort;

    if (isset($limit) && !empty($limit) && is_int($limit))
      $sql .= ' LIMIT ' . $this->_db->quoteSmart($limit);

    $sql .= ';';

    $result = $this->_db->getAll($sql);
    if (PEAR::isError($result)) {
      error_log("__CLASS__::__METHOD__ DB error from query ( $sql ): " . $result->GetMessage());
      return false;
    }

    if (!isset($result) || empty($result))
      return 'No Results';
    else {
      // This loop is to ensure every chapter name is properly escaped for html
      //        foreach( $result as &$c )
      //        {
      //          $c['name'] = htmlspecialchars( $c['name'], ENT_QUOTES );
      //        }
      return $result;
    }
  }


  // All methods past this point modify the DB

  function _db_insert($values)
  {
    if (empty($values)) return false;

    $values .= ', broadcasterid=' . $this->_db->quoteSmart(PFS_BROADCASTERID);

    $sql = "INSERT INTO agenda_items SET $values;";

    $result = $this->_db->query($sql);

    if (PEAR::isError($result)) {
      error_log("__CLASS__::__METHOD__ DB error from query ( $sql ): " . $result->GetMessage());
      return false;
    }
    return true;
  }

  function _db_delete($criteria)
  {
    if (empty($criteria)) return false;

    $sql = "UPDATE agenda_items SET deleted=1 WHERE broadcasterid=' . $this->_db->quoteSmart( PFS_BROADCASTERID ) . ' AND ' . $criteria;";

    $result = $this->_db->query($sql);

    if (PEAR::isError($result)) {
      error_log("__CLASS__::__METHOD__ DB error from query ( $sql ): " . $result->GetMessage());
      return false;
    }
    return true;
  }

  function _db_update($values, $criteria)
  {
    if (empty($criteria)) return false;
    if (empty($values)) return false;

    $sql = "UPDATE agenda_items SET date = CURRENT_TIMESTAMP, $values WHERE NOT deleted AND broadcasterid=' . $this->_db->quoteSmart( PFS_BROADCASTERID ) . ' AND $criteria;";

    $result = $this->_db->query($sql);

    if (PEAR::isError($result)) {
      error_log("__CLASS__::__METHOD__ DB error from query ( $sql ): " . $result->GetMessage());
      return false;
    }
    return true;
  }

  function newChapter($mediaid, $name, $time_offset)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_time_offset = $this->_db->quoteSmart($time_offset);
    $db_name = $this->_db->quoteSmart($name);

    $values = "mediaid=$db_mediaid, offset=$db_time_offset, name=$db_name";

    return $this->_db_insert($values);
  }


  function delChapter($mediaid, $chapterid)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_chapterid = $this->_db->quoteSmart($chapterid);

    $criteria = "mediaid=$db_mediaid AND id=$db_chapterid";

    return $this->_db_delete($criteria);
  }

  function setChapterName($mediaid, $chapterid, $name)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_chapterid = $this->_db->quoteSmart($chapterid);
    $db_name = $this->_db->quoteSmart($name);

    $values = "name=$db_name";
    $criteria = "mediaid=$db_mediaid AND id=$db_chapterid";

    return $this->_db_update($values, $criteria);
  }

  // Setting the Chapter's time offset, automatically posts the chapter
  function setChapterOffset($mediaid, $chapterid, $time_offset)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_chapterid = $this->_db->quoteSmart($chapterid);
    $db_time_offset = $this->_db->quoteSmart($time_offset);

    $values = "offset=$db_time_offset, posted=1";
    $criteria = "mediaid=$db_mediaid AND id=$db_chapterid";

    return $this->_db_update($values, $criteria);
  }

  function postChapter($mediaid, $chapterid)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_chapterid = $this->_db->quoteSmart($chapterid);

    $criteria = "mediaid=$db_mediaid AND id=$db_chapterid";
    $values = "date = CURRENT_TIMESTAMP, posted = 1";

    return $this->_db_update($values, $criteria);
  }

  function unpostChapter($mediaid, $chapterid)
  {
    if (!isset($this->_db)) return false;

    $db_mediaid = $this->_db->quoteSmart($mediaid);
    $db_chapterid = $this->_db->quoteSmart($chapterid);

    $criteria = "mediaid=$db_mediaid AND id=$db_chapterid";
    $values = "date = CURRENT_TIMESTAMP, posted = 0";

    return $this->_db_update($values, $criteria);
  }
} // class CChapters
