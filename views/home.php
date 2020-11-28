<section class="content-header">
    <h1>
        Home
    </h1>

</section>

<!-- Main content -->
<section class="content container-fluid">

    <div class="box">

        <section class="content-header">

            <h1>Os 10 Países com mais acesso</h1>
        </section>

        <section class="content container-fluid">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <th>País</th>
                        <th>Quantidade</th>
                    </tr>

                    <?php foreach ($list as $item) : ?>
                        <tr>
                            <td><?php echo $item['country']; ?></td>
                            <td><?php echo $item['c']; ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <hr>

            </div>
        </section>

</section>
<!-- /.content -->