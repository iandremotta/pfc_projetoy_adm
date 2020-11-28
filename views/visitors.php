<section class="content-header">

    <h1>Visitantes</h1>
</section>

<section class="content container-fluid">


    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Filtro</h3>
            <div class="box-body">
                <form method="get">
                    <div class="row">
                        <div class="col-sm-8">
                            <label>País ou cidade</label>
                            <input type="text" name="data" id="form_user" class="form-control" value="<?php if (isset($_GET['data'])) {
                                                                                                            echo $_GET['data'];
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                        } ?>">
                        </div>

                        <div class="col-sm-4">
                            <label>&nbsp;</label><br>
                            <input type="submit" value="Filtrar" class="btn btn-primary">
                            <a href="<?php BASE_URL; ?>visitors" class="btn btn-danger">Limpar</a>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>




    <div class="box">
        <!-- <div class="box-header">
            <h3 class="box-title">Usuários</h3>
            <div class="box-tools">
                <a href="<?php echo BASE_URL . 'users/add'; ?>" class="btn btn-success">Adicionar</a>
            </div>
        </div> -->
    </div>

    <div class="box-body">
        <table class="table">
            <tr>
                <th>IP</th>
                <th>País</th>
                <th>Cidade</th>
                <th>Data</th>
                <th>Usuário</th>
            </tr>

            <?php foreach ($list as $item) : ?>
                <tr>
                    <td><?php echo $item['ip']; ?></td>
                    <td><?php echo $item['country']; ?></td>
                    <td><?php echo $item['region']; ?></td>
                    <td><?php echo $item['date_access']; ?></td>
                    <td><?php echo $item['name']; ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
        <hr>
        <?php
        $total_pages = ceil(($pag['total'] / $pag['per_page']));
        ?>
        <?php for ($q = 0; $q < $total_pages; $q++) : ?>
            <a href="<?php $items = $_GET;
                        unset($items['url']);
                        $items['p'] = ($q + 1);
                        echo BASE_URL . 'visitors?' . http_build_query($items);
                        // print_r($items); 
                        ?>">
                <?php echo ($q == $pag['currentpage']) ? '<strong>[' . ($q + 1) . ']</strong>' : '[' . ($q + 1) . '] '; ?>

            </a>
        <?php endfor; ?>
    </div>
</section>