<?php

class VisitorsDAO extends dao
{

    private function buildGetFilterSql($filter)
    {
        $sqlfilter = array();

        if (!empty($filter['data'])) {
            $sqlfilter[] = '(country LIKE :country OR region LIKE :region)';
        }
        return $sqlfilter;
    }

    private function buildGetFilterBind($filter, &$sql)
    {
        if (!empty($filter['data'])) {
            $sql->bindValue(':country', '%' . $filter['data'] . '%');
            $sql->bindValue(':region', '%' . $filter['data'] . '%');
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

        $sql = "SELECT DISTINCT v.ip, v.country, v.date_access,v.region, (SELECT name from USERS where id = v.user_id) as name FROM visitors AS v, users AS u";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }
        $sql .= " ORDER BY country ASC LIMIT " . $pagfilter['offset'] . ',' . $pagfilter['limit'];
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
        $sql = "SELECT  count(*) as c FROM visitors";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }

        $sql = $this->db->prepare($sql);

        $this->buildGetFilterBind($filter, $sql);

        $sql->execute();
        $data = $sql->fetch();
        return $data['c'];
    }

    public function getCountryQuantity()
    {
        $data = array();
        $sql = "select count(*) as c, country from visitors group by country ORDER BY C desc LIMIT 10";
        $sql = $this->db->query($sql);
        $sql->execute();
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        // print_r($data);
        // exit;
        return $data;
    }
}
