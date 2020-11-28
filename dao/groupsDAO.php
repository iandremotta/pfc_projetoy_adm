<?php

class GroupsDAO extends dao
{


    public function getNamesByArray($id_groups)
    {
        $array = array();
        if (count($id_groups) > 0) {
            $sql = "SELECT name, id FROM groups WHERE id in (" . (implode(',', $id_groups)) . ")";

            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return $array;
    }

    public function activeGroup($group)
    {
        $sql = "UPDATE groups SET deleted = 0 WHERE ID = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $group->getId());
        $sql->execute();
    }

    public function inactiveGroup($group)
    {
        $sql = "UPDATE groups SET deleted = 1 WHERE ID = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $group->getId());
        $sql->execute();
    }

    private function buildGetFilterSql($filter)
    {
        $sqlfilter = array();

        if (!empty($filter['data'])) {
            $sqlfilter[] = '(name LIKE :name)';
        }
        return $sqlfilter;
    }

    private function buildGetFilterBind($filter, &$sql)
    {
        if (!empty($filter['data'])) {
            $sql->bindValue(':name', '%' . $filter['data'] . '%');
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

        $sql = "SELECT * FROM groups";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }
        $sql .= " ORDER BY name ASC LIMIT " . $pagfilter['offset'] . ',' . $pagfilter['limit'];
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
        $sql = "SELECT count(*) as c FROM groups";
        if (count($sqlfilter) > 0) {
            $sql .= " WHERE " . implode(' AND ', $sqlfilter);
        }

        $sql = $this->db->prepare($sql);

        $this->buildGetFilterBind($filter, $sql);

        $sql->execute();
        $data = $sql->fetch();
        return $data['c'];
    }
}
