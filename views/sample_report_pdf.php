<?php
unset($filters['rand']);
unset($filters['type']);
unset($filters['title']);
unset($filters['from_date']);
unset($filters['to_date']);
unset($filters['from_date_execution']);
unset($filters['to_date_execution']);
?>
<html>

<head>
    <title>Raport <?= $type ?></title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <style>
        @page {
            margin-bottom: 0 !important;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            margin-top: -5px;
            margin-top: 10px;
        }

        td,
        th {
            border: 1px solid black;
            padding: 2px;
            font-size: 10px;
        }

        table th {
            background-color: #99ccff;
            color: black;
        }

        p,
        span,
        div {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <p>
        <?= $this->lang->line('company') ?>: <?= $company ?>
        <span style="float:right; ">
            <?= $this->lang->line('date') ?>: <?= date("d.m.Y") ?>
        </span>
    </p>

    <p style="text-align:center; font-size: 16px; font-weight: bold;">

        <?= $title ?>
    </p>
    <br>
    <?php foreach ($filters as $key => $filter) : ?>
        <?php if (is_array($filter)) : ?>
            <p><?= $this->lang->line($key) . ': ' . implode(', ', $filter) ?></p>
        <?php elseif ($filter) : ?>
            <p><?= $this->lang->line($key) . ': ' . $this->lang->line($filter) ?></p>
        <?php endif ?>
    <?php endforeach; ?>
    <div>
        Perioada:
        <p style=" display: inline;">
            <?= $from_date ?>
        </p> -
        <p style=" display: inline;">
            <?= $to_date ?>
        </p>
    </div>

    <?php if (isset($from_date_exec) || isset($to_date_exec)) { ?>
        <div>
            <?= $type === '5' ? $this->lang->line('delivery_time') : $this->lang->line('term_of_execution') ?>:
            <?php if (isset($from_date_exec)) { ?>
                <p style=" display: inline;">
                    <?= date('d.m.Y', strtotime($from_date_exec)) ?>
                </p>
            <?php } ?>

            <?php if (isset($to_date_exec)) { ?>
                -
                <p style=" display: inline;">
                    <?= date('d.m.Y', strtotime($to_date_exec)) ?>
                </p>
            <?php } ?>
        </div>
    <?php } ?>

    <table>
        <tr>
            <th style="width: 60px;"><?= $this->lang->line($option_date); ?></th>
            <?php if ($type === '1') { ?>
                <th><?= $this->lang->line('clients'); ?></th>
                <th><?= $this->lang->line('client_reference'); ?></th>
                <th><?= $this->lang->line('name'); ?></th>
                <th><?= $this->lang->line('composition'); ?></th>
                <th><?= $this->lang->line('metric_number'); ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('no_of_pieces') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
                <th><?= $this->lang->line('in_charge') ?> </th>
                <th><?= $this->lang->line('in_charge_confection') ?></th>
                <th><?= $this->lang->line('in_charge_client') ?></th>
                <th style="width: 60px;"><?= $this->lang->line('term_of_execution') ?></th>
            <?php } elseif ($type === '2') { ?>
                <th><?= $this->lang->line('clients'); ?></th>
                <th><?= $this->lang->line('client_reference'); ?></th>
                <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('no_of_pieces') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
            <?php } elseif ($type === '3') { ?>
                <th><?= $this->lang->line('in_charge') ?></th>
                <th><?= $this->lang->line('in_charge_confection') ?></th>
                <th><?= $this->lang->line('in_charge_client') ?></th>
                <th><?= $this->lang->line('clients') ?></th>
                <th><?= $this->lang->line('client_reference') ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
                <th style="width: 60px;"><?= $this->lang->line('term_of_execution') ?></th>
            <?php } elseif ($type === '4') { ?>
                <th><?= $this->lang->line('name') ?></th>
                <th><?= $this->lang->line('composition') ?></th>
                <th><?= $this->lang->line('metric_number') ?></th>
                <th><?= $this->lang->line('client_reference') ?></th>
                <th><?= $this->lang->line('clients') ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('no_of_pieces') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
                <th><?= $this->lang->line('sample_done') ?></th>
            <?php } elseif ($type === '5') { ?>
                <th><?= $this->lang->line('in_charge') ?></th>
                <th><?= $this->lang->line('in_charge_confection') ?></th>
                <th><?= $this->lang->line('startup_name') ?></th>
                <th><?= $this->lang->line('clients') ?></th>
                <th><?= $this->lang->line('client_reference') ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('launch_quantity') ?></th>
                <th><?= $this->lang->line('knitting_qty') ?></th>
                <th><?= $this->lang->line('for_knitting_qty') ?></th>
                <th><?= $this->lang->line('delivery_time') ?></th>
                <!-- <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('no_of_pieces') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
                <th><?= $this->lang->line('term_of_execution') ?></th> -->
            <?php } ?>
        </tr>
        <?= $rows ?>
    </table>
    <?php if ($type === '5') { ?>
        <table>
            <tr>
                <th style="width: 60px;"><?= $this->lang->line('request_date'); ?></th>
                <th><?= $this->lang->line('in_charge') ?></th>
                <th><?= $this->lang->line('in_charge_confection') ?></th>
                <th><?= $this->lang->line('clients') ?></th>
                <th><?= $this->lang->line('client_reference') ?></th>
                <th><?= $this->lang->line('fineness') ?></th>
                <th><?= $this->lang->line('sample_type') ?></th>
                <th><?= $this->lang->line('no_of_pieces') ?></th>
                <th><?= $this->lang->line('done_pieces') ?></th>
                <th><?= $this->lang->line('for_done_pieces') ?></th>
                <th><?= $this->lang->line('term_of_execution') ?></th>
            </tr>

            <?= $rows_second_tbl ?>
        </table>
    <?php } ?>
</body>

</html>