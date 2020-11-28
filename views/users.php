<section class="content-header">

    <h1>Usuário</h1>
</section>

<section class="content container-fluid">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Filtro</h3>
            <div class="box-body">
                <form method="get">
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Username ou email</label>
                            <input type="text" name="data" id="form_user" class="form-control" value="<?php if (isset($_GET['data'])) {
                                                                                                            echo $_GET['data'];
                                                                                                        } else {
                                                                                                            echo '';
                                                                                                        } ?>">
                        </div>

                        <div class="col-sm-4">
                            <label>&nbsp;</label><br>
                            <input type="submit" value="Filtrar" class="btn btn-primary">
                            <a href="<?php BASE_URL; ?>/users" class="btn btn-danger">Limpar</a>
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
                <th>Nome</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Last Login</th>
                <th>Status</th>
                <th>Administrador</th>
                <th width="130">Ações</th>
            </tr>

            <?php foreach ($list as $item) : ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['username']; ?></td>
                    <td><?php echo $item['email']; ?></td>
                    <td><?php echo $item['last_login']; ?></td>
                    <td><?php if ($item['deleted'] == 0) : ?>
                            <p>Ativo</p>
                        <?php else : ?>
                            <p>Inativo</p>
                        <?php endif; ?>
                    </td>
                    <td><?php if ($item['admin'] == 1) : ?>
                            <p>Sim</p>
                        <?php else : ?>
                            <p>Não</p>
                        <?php endif;; ?></td>
                    <td>
                        <div class="btn-group">
                            <?php if ($item['deleted'] == 0) : ?>
                                <a href="<?php echo BASE_URL . 'users/inactive/' . $item['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Desativar usuário?')">Desativar</a>
                            <?php else : ?>
                                <a href="<?php echo BASE_URL . 'users/active/' . $item['id']; ?>" class="btn btn-xs btn-success" onclick="return confirm('Ativar usuário?')">Ativar</a>
                            <?php endif; ?>
                        </div>
                    </td>
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
                        echo BASE_URL . 'users?' . http_build_query($items);
                        // print_r($items); 
                        ?>">
                <?php echo ($q == $pag['currentpage']) ? '<strong>[' . ($q + 1) . ']</strong>' : '[' . ($q + 1) . '] '; ?>

            </a>
        <?php endfor; ?>
    </div>
</section>