<?php
/**
 * @author      Leo Stalder
 * @date        30.05.18
 *
 * Datenbankschnittstelle
 * Stellt grundlegende Datenbankfunktionen zur Verfügung. 
 */
class db {
        private static $dbhandle = Null;              // DB-Handle

        /**
         * Konstruktor
         */
        public function __construct() {
            db::connect( 'VIDEOPLAYER', 'root', '' );
        }

	/**
	 * Datenbankverbinndung herstellen
         * @param String $database Bezeichnung der Datenbank
         * @param String $username Benutzername für den Zugriff auf die Datenbank
         * @param String $password Kennwort für den Zugriff auf die Datenbank
	 */
	private static function connect( $database, $username, $password ) {   
            if (self::$dbhandle == Null) {
                try {
                    self::$dbhandle = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
                    self::$dbhandle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    throw new Exception (get_class($this).': Connection failed: ' . $e->getMessage());
                }
            }
	}

	/**
	 * Escaped einen String, Wildcards werden nicht escaped
	 * @param String $value, wert der Escaped wird (Referenz)
	 */
	private function escape( $value ) {
            return htmlspecialchars(self::$dbhandle->quote($value));
	}
        
        /**
         * Escaped ein Array, Wildcards werden nicht escaped
         * 
         * @param type $params
         * @return type escaptes array
         */
        private function escapeAll($params) {
            foreach ($params as $param) {
                $param = $this->escape($param);
            }
            return $params;
        }
        
	/**
	 * Übergebenen Select ausführen und Resultat im assoziativen Array speichern
         * @param String $sql SQL-Select, welcher ausfgeführt werden soll
	 */
	private function select( $sql ) {
            try {
                $sth = self::$dbhandle->query($sql);
                return $sth->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                throw new Exception (get_class($this).': Fehler in Select: '.$e->getMessage());
            }
	}

	/**
	 * Query ( insert, update, delete )auf der Datenbank ausführen
         * @param String $sql SQL-Anweisung, welche ausfgeführt werden soll
	 */
	private function query( $sql ) {
            try {
                self::$dbhandle->query($sql);
            } catch (PDOException $e) {
                throw new Exception(get_class($this).': Fehler in Query: ' . $e->getMessage()."<pre>".$sql."</pre>");
            }        
            return self::$dbhandle->lastInsertId();
	}
        
        private function preparedStatementQuery($sql, $params) {
            try {
                $params = $this->escapeAll($params);
                $statement = self::$dbhandle->prepare($sql);
                $statement->execute($params);
                return $statement;
            } catch (PDOException $ex) {
                throw new Exception(get_class($this).': Fehler in Prepared Statement Query: ' . $ex->getMessage()."<pre>".$sql."</pre>");
            }
        }
        
        private function preparedStatementSelect($sql, $params) {
            try {
                $params = $this->escapeAll($params);
                $statement = $this->preparedStatementQuery($sql, $params);
                if ($statement) {
                    return $statement->fetchAll(PDO::FETCH_OBJ);
                }
            } catch (PDOException $ex) {
                throw new Exception(get_class($this).': Fehler in Prepared Statement Select: ' . $e->getMessage()."<pre>".$sql."</pre>");
            }
        }
        
        public function lastId() {
            return self::$dbhandle->lastInsertId();
        }
        
        public function startTransaction() {
            return self::$dbhandle->beginTransaction();
        }
        
        public function commit() {
            return self::$dbhandle->commit();
        }
        
        public function rollback() {
            self::$dbhandle->rollBack();
        }
        
        public function selectVideo($vid) {
            //Parameter in Arrayschreiben für generelle selectfunktion
            $params = array();
            $params[] = $vid;
            
            $return = $this->preparedStatementSelect("select * from video where vid = ?", $params);
            if (!empty($return)) return new video($return[0]->VID, $return[0]->BEZ, $return[0]->VIDEO, $return[0]->VORSCHAUBILD);
            else return null;
        }
        
        public function selectAllVideos() {
            //Parameter in Arrayschreiben für generelle selectfunktion
            $params = array();
            
            $return = $this->preparedStatementSelect("select * from video", $params);
            
            $videos = array();
            foreach ($retrun as $video) {
                array_push($videos, new video($video->VID, $video->BEZ, $video->VIDEO, $video->VORSCHAUBILD));
            }
            return $videos;
        }
        
        public function selectPlaylist($pid) {
            //Parameter in Arrayschreiben für generelle selectfunktion
            $params = array();
            $params[] = $pid;
            
            $return = $this->preparedStatementSelect("select p.PID, p.BEZ as P_BEZ, v.* from video_playlist vp
            inner join playlist p on vp.pid = p.pid
            inner join video v on v.vid = vp.vid
            where vp.pid = ?", $params);
            if (!empty($return)) {
                $videos = array();
                foreach ($return as $key => $value) {
                    $videos[] = new video($value->VID, $value->BEZ, $value->VIDEO, $value->VORSCHAUBILD);
                }
                return new playlist($return[0]->PID, $return[0]->P_BEZ, $videos);
            }
            else return null;
        }
}


