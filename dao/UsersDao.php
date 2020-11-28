<?php

class UsersDao extends dao
{


    public function verifyLogin()
    {
        if (!empty($_SESSION['chathashlogin'])) {
            $s = $_SESSION['chathashlogin'];
            $sql = "SELECT * FROM users WHERE loginhash = :hash AND admin = 1";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":hash", $s);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $data = $sql->fetch();
                $this->uid = $data['id'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function validateUser($users)
    {

        $sql = "SELECT * FROM users WHERE email = :email AND deleted = 0 AND admin = 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email", $users->getEmail());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $info = $sql->fetch();
            if (password_verify($users->getPass(), $info['pass'])) {
                $loginhash = md5(rand(0, 99999) . time() . $info['id'] . $info['email']);
                $this->setLoginHash($info['id'], $loginhash);
                $_SESSION['chathashlogin'] = $loginhash;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findBy()
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $this->uid);
        $sql->execute();
        $data = $sql->fetch();
        return $data;
    }


    private function setLoginHash($uid, $hash)
    {

        $sql = "UPDATE users SET loginhash = :hash WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":hash", $hash);
        $sql->bindValue(":id", $uid);
        $sql->execute();
    }



    private function buildGetFilterSql($filter)
    {
        $sqlfilter = array();

        if (!empty($filter['data'])) {
            $sqlfilter[] = '(username LIKE :username OR email LIKE :email)';
        }
        return $sqlfilter;
    }

    private function buildGetFilterBind($filter, &$sql)
    {
        if (!empty($filter['data'])) {
            $sql->bindValue(':username', '%' . $filter['data'] . '%');
            $sql->bindValue(':email', '%' . $filter['data'] . '%');
        }
    }
    public function getAll($filter = array(), $pag = array())
    {
        $array = array();
        $sqlfilter = $this->buildGetFilterSql($filter);

        $pagfilter = array(
            'offset' => 0,
            'limit' => 2,
        );

        if (!empty($pag['per_page'])) {
            $pagfilter['limit'] = $pag['per_page'];
        }

        if (!empty($pag['currentpage'])) {
            $pagfilter['offset'] = $pag['currentpage'] * $pagfilter['limit'];
        }

        // echo $pagfilter['offset'];
        // exit;
        // print_r($pagfilter);
        // exit;

        $sql = "SELECT * FROM users";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }
        $sql .= " ORDER BY admin DESC LIMIT " . $pagfilter['offset'] . ',' . $pagfilter['limit'];
        $sql = $this->db->prepare($sql);

        $this->buildGetFilterBind($filter, $sql);

        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getTotal($filter = array())
    {
        $array = array();
        $sqlfilter = $this->buildGetFilterSql($filter);
        $sql = "SELECT count(*) as c FROM users";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }

        $sql = $this->db->prepare($sql);

        $this->buildGetFilterBind($filter, $sql);

        $sql->execute();
        $data = $sql->fetch();
        return $data['c'];
    }

    public function getNewUsers()
    {
        $sql = "select count(*) from users where created_at = current_date";
        $sql = $this->db->query($sql);
        $sql->execute();
        $data = $sql->fetch();
        return $data[0];
    }

    public function activeUser($users)
    {
        $sql = "UPDATE USERS SET deleted = 0 WHERE ID = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $users->getId());
        $sql->execute();
    }
    public function inactiveUser($users)
    {
        $sql = "UPDATE USERS SET deleted = 1 WHERE ID = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $users->getId());
        $sql->execute();
    }
};
