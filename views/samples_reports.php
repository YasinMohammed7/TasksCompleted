<?php
$date_label = "";
if ($type === '3') {
    $date_label = $this->lang->line('done_date');
} elseif ($type === '5') {
    $date_label = $this->lang->line('startup_date');
} else {
    $date_label = $this->lang->line('request_date');
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title ?> | <?= $this->lang->line('platform_company') ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('resources/header.php'); ?>

</head>

<style>
    /* #search_form {
        margin-left: 30px;
    } */
</style>

<body class="materialdesign">
    <!-- Header top area start-->
    <div class="wrapper-pro">
        <?php $this->load->view('resources/sidebar.php'); ?>
        <!-- Header top area start-->
        <div class="content-inner-all">
            <?php $this->load->view('resources/main_menu.php'); ?>
            <?php $this->load->view('resources/mobile.php'); ?>

            <div class="dashtwo-order-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Transitions Start-->
                            <div class="transition-world-area" style="margin: 20px 0;">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-20">
                                            <div class="transition-world-list shadow-reset">
                                                <div class="sparkline7-list">
                                                    <div class="sparkline7-hd">
                                                        <div class="main-spark7-hd">
                                                            <h1> <span class="res-ds-n"><?php echo $title; ?></span></h1>
                                                            <div class="breadcome_right">
                                                                <ul class="breadcome-menu">
                                                                    <li><a href="<?php echo base_url() ?>index.php/users/dashboard_pro">Home</a> <span class="bread-slash">/</span>
                                                                    </li>
                                                                    <li><span class="bread-blod"><?php echo $title; ?></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="sparkline7-graph">
                                                        <form method="post" id="sample_report" style="display: flex; flex-direction:column; gap:10px;">

                                                            <div style="display: flex;">

                                                                <div class="col-lg-2" style="align-self: center;">
                                                                    <div class="login-input-head pull-right pull-right-pro">
                                                                        <p><b><?php echo $date_label ?></b></p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2" style="padding-top: 10px">
                                                                    <div class="interested-input-area">
                                                                        <div class="form-group data-custon-pick" id="data_2">
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                <input class="form-control" type="text" id="from_date" name="from_date" value="<?php echo date('d/m/Y') ?>" autocomplete="off" placeholder="DD-MM-YYYY" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2" style="padding-top:10px">
                                                                    <div class="interested-input-area">
                                                                        <div class="form-group data-custon-pick" id="data_2">
                                                                            <div class="input-group date">
                                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                <input class="form-control" type="text" id="to_date" name="to_date" value="<?php echo date('d/m/Y') ?>" autocomplete="off" placeholder="DD-MM-YYYY" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div style="display: flex;">
                                                                <div class="col-lg-2" style="align-self: center;">
                                                                    <div class="login-input-head pull-right pull-right-pro">
                                                                        <b style="padding-top:3px"><?php echo $this->lang->line('name_of_fineness'); ?></b>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="chosen-select-single">
                                                                        <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('name_of_fineness'); ?>" multiple="" tabindex="-1" name="fineness[]" id="fineness">
                                                                            <!-- <option disabled value="">Alege finete</option> -->
                                                                            <?php foreach ($fineness as $item) { ?>
                                                                                <option value="<?= $item ?>"><?= $item ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <button class="btn btn-custon-four btn-primary btn-md" id="all_fineness"><?= $this->lang->line('all') ?></button>
                                                                </div>
                                                            </div>

                                                            <?php if ($type === '1' || $type === '2' || $type === '3') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('clients'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('clients'); ?>" multiple="" tabindex="-1" name="clients[]" id="clients">
                                                                                <!-- <option disabled value="">Alege client</option> -->
                                                                                <?php foreach ($clients as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_clients"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type !== '5') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('sample_type'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('sample_type'); ?>" multiple="" tabindex="-1" name="samplers_details[]" id="samplers_details">
                                                                                <!-- <option disabled value="">Alege tip monstra</option> -->
                                                                                <?php foreach ($sample_details as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_samplers_details"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type === '1' || $type === '3') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('in_charge_client'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('in_charge_client'); ?>" multiple="" tabindex="-1" name="in_charge_client[]" id="in_charge_client">
                                                                                <!-- <option disabled value="">Alege responsabil client</option> -->
                                                                                <?php foreach ($in_charge_client as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_in_charge_client"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type === '1' || $type === '3' || $type === '5') { ?>
                                                                <!-- <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('term_of_execution'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('term_of_execution'); ?>" multiple="" tabindex="-1" name="expiry_date[]" id="expiry_date">
                                                                                <option disabled value="">Alege termen de executie</option>
                                                                                <?php foreach ($expiry_date as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_expiry_date"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div> -->

                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('in_charge'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('in_charge'); ?>" multiple="" tabindex="-1" name="in_charge[]" id="in_charge">
                                                                                <!-- <option disabled value="">Alege responsabil tricotat</option> -->
                                                                                <?php foreach ($in_charge as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_in_charge"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('in_charge_confection'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('in_charge_confection'); ?>" multiple="" tabindex="-1" name="in_charge_confection[]" id="in_charge_confection">
                                                                                <!-- <option disabled value="">Alege responsabil confectie</option> -->
                                                                                <?php foreach ($in_charge_confection as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_in_charge_confection"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>



                                                                <div style="display: flex;">

                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <p><b><?php echo $type === '5' ? $this->lang->line('delivery_time') : $this->lang->line('term_of_execution') ?></b></p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-2" style="padding-top: 10px">
                                                                        <div class="interested-input-area">
                                                                            <div class="form-group data-custon-pick" id="data_2">
                                                                                <div class="input-group date">
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                    <input class="form-control" type="text" id="from_date_execution" name="from_date_execution" value="" autocomplete="off" placeholder="DD-MM-YYYY">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-2" style="padding-top:10px">
                                                                        <div class="interested-input-area">
                                                                            <div class="form-group data-custon-pick" id="data_2">
                                                                                <div class="input-group date">
                                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                    <input class="form-control" type="text" id="to_date_execution" name="to_date_execution" value="" autocomplete="off" placeholder="DD-MM-YYYY">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type === '4') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('composition'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('composition'); ?>" multiple="" tabindex="-1" name="composition[]" id="composition">
                                                                                <!-- <option disabled value="">Alege compozitie</option> -->
                                                                                <?php foreach ($composition as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_composition"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>

                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('metric_number'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('metric_number'); ?>" multiple="" tabindex="-1" name="metric_number[]" id="metric_number">
                                                                                <!-- <option disabled value="">Alege numar metric</option> -->
                                                                                <?php foreach ($metric_number as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_metric_number"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>

                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('name'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo $this->lang->line('name'); ?>" multiple="" tabindex="-1" name="name[]" id="name">
                                                                                <!-- <option disabled value="">Alege numar metric</option> -->
                                                                                <?php foreach ($name as $item) { ?>
                                                                                    <option value="<?= $item ?>"><?= $item ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_name"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>

                                                                <div style="display: flex; margin-bottom: 20px;">
                                                                    <div class="col-lg-2" style="align-self: center;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?php echo $this->lang->line('client_reference'); ?></b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="chosen-select-single">
                                                                            <select class="chosen-select" data-placeholder="<?php echo preg_replace('/<[^>]*>/', ' ', $this->lang->line('client_reference')); ?>" multiple="" tabindex="-1" name="client_reference[]" id="ref_client">
                                                                                <!-- <option disabled value="">Alege finete</option> -->
                                                                                <?php foreach ($ref_clients as $ref) { ?>
                                                                                    <option value="<?= $ref ?>"><?= $ref ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button class="btn btn-custon-four btn-primary btn-md" id="all_ref_clients"><?= $this->lang->line('all') ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($type === '3') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"><?= $this->lang->line('selection_after') ?></b>
                                                                        </div>
                                                                    </div>

                                                                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                                                        <label for="total">
                                                                            <input type="radio" name="selection_after" id="total" value="total">
                                                                            Total
                                                                        </label>
                                                                        <label for="total_per_in_charge">
                                                                            <input type="radio" name="selection_after" id="total_per_in_charge" value="total_per_in_charge">
                                                                            Total per <?= $this->lang->line('in_charge') ?>
                                                                        </label>
                                                                        <label for="total_per_in_charge_confection">
                                                                            <input type="radio" name="selection_after" id="total_per_in_charge_confection" value="total_per_in_charge_confection">
                                                                            Total per <?= $this->lang->line('in_charge_confection') ?>
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type !== '3' && $type !== '5') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"> Total client</b>
                                                                        </div>
                                                                    </div>
                                                                    <input type="checkbox" name="total_client" id="total_client">

                                                                </div>
                                                            <?php } ?>

                                                            <?php if ($type === '5') { ?>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-2">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"> <?= $this->lang->line('knitting_qty') ?>e =0</b>
                                                                        </div>
                                                                    </div>
                                                                    <input type="checkbox" name="knitting_qty" id="knitting_qty">

                                                                </div>
                                                                <div style="display: flex;">
                                                                    <div class="col-lg-3" style="display: flex; gap: 15px;">
                                                                        <div class="login-input-head pull-right pull-right-pro">
                                                                            <b style="padding-top:3px"> <?= $this->lang->line('for_done_pieces') ?> >0</b>
                                                                        </div>
                                                                        <input type="checkbox" name="for_done_pieces" id="for_done_pieces">
                                                                    </div>


                                                                </div>
                                                            <?php } ?>

                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="login-button-pro">
                                                                        <button type="submit" class="btn btn-custon-four btn-primary btn-md" value="Submit" name="submit_report" id="submit_report"><?php echo $this->lang->line('generate_report'); ?></button>

                                                                        <button type="button" class="btn btn-custon-four btn-primary btn-md" onclick="resetForm()"><?php echo $this->lang->line('reset_report'); ?></button>

                                                                        <button type="button" id="export_excel" class="btn btn-custon-four btn-primary btn-md">Export Excel</button>
                                                                        <!-- <button type="button" class="btn btn-custon-four btn-primary btn-md"><?= !$generate_report ? "0" : "1"; ?></button> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <input type="hidden" name="" id="buff_date">
                                                        <input type="hidden" name="" id="buff_date_execution">

                                                    </div>

                                                    <div id="pdf-table" style="display: none;" class="sparkline7-graph">
                                                        <div class="sparkline7-graph">
                                                            <iframe src="" width="100%" height="1200px"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('resources/footer_login_pro'); ?>
    <?php $this->load->view('resources/js_main'); ?>
    <script src="<?php echo base_url('asset/theme_tricosoft/js/chosen/chosen.jquery.js') ?>"></script>
    <script src="<?php echo base_url('asset/theme_tricosoft/js/chosen/chosen-active.js') ?>"></script>
    <script>
        function resetForm() {
            const currUrl = window.location.href;
            location.href = currUrl;
        }
        jQuery(document).ready(function() {
            console.log('ready');

            // Buton toate
            $('#all_fineness').on('click', function(e) {
                e.preventDefault();
                $('#fineness option').prop('selected', true);
                $('#fineness').chosen().trigger('chosen:updated');
            });

            $('#all_clients').on('click', function(e) {
                e.preventDefault();
                $('#clients option').prop('selected', true);
                $('#clients').chosen().trigger('chosen:updated');
            });
            $('#all_samplers_details').on('click', function(e) {
                e.preventDefault();
                $('#samplers_details option').prop('selected', true);
                $('#samplers_details').chosen().trigger('chosen:updated');
            });

            $('#all_composition').on('click', function(e) {
                e.preventDefault();
                $('#composition option').prop('selected', true);
                $('#composition').chosen().trigger('chosen:updated');
            });

            $('#all_metric_number').on('click', function(e) {
                e.preventDefault();
                $('#metric_number option').prop('selected', true);
                $('#metric_number').chosen().trigger('chosen:updated');
            });

            $('#all_name').on('click', function(e) {
                e.preventDefault();
                $('#name option').prop('selected', true);
                $('#name').chosen().trigger('chosen:updated');
            });

            $('#all_in_charge').on('click', function(e) {
                e.preventDefault();
                $('#in_charge option').prop('selected', true);
                $('#in_charge').chosen().trigger('chosen:updated');
            });

            $('#all_in_charge_confection').on('click', function(e) {
                e.preventDefault();
                $('#in_charge_confection option').prop('selected', true);
                $('#in_charge_confection').chosen().trigger('chosen:updated');
            });

            $('#all_in_charge_client').on('click', function(e) {
                e.preventDefault();
                $('#in_charge_client option').prop('selected', true);
                $('#in_charge_client').chosen().trigger('chosen:updated');
            });

            $('#all_ref_clients').on('click', function(e) {
                e.preventDefault();
                $('#ref_client option').prop('selected', true);
                $('#ref_client').chosen().trigger('chosen:updated');
            });

            // $('#all_expiry_date').on('click', function(e) {
            //     e.preventDefault();
            //     $('#expiry_date option').prop('selected', true);
            //     $('#expiry_date').chosen().trigger('chosen:updated');
            // });

            $('#sample_report').on('submit', function(e) {
                e.preventDefault();
                const now = new Date();
                const formattedTime = now.getHours() + '-' + now.getMinutes() + '-' + now.getSeconds();
                var formData = $(this).serialize();
                console.log(formData);

                $('#pdf-table').show();
                $('iframe').attr('src', '<?php echo base_url(); ?>index.php/Reports/samples_report_pdf?type=<?php echo $type; ?>&title=<?php echo $title; ?>&' + formData + '&rand=' + formattedTime);
                $('#export_excel').data('formData', formData);
            });

            $('#export_excel').on('click', function(e) {
                e.preventDefault();
                var formData = $(this).data('formData') || '';

                if (formData === '') {
                    alert('Nu exista date pentru export');
                    return;
                }

                var url = '<?php echo base_url(); ?>index.php/Reports/samples_report_excel?type=<?php echo $type; ?>&title=<?php echo $title; ?>&' + formData;
                window_xls = window.open(url);

                // Opțional, reîncarcăm fereastra deschisă
                window_xls.location.reload(true);
            });



            $('#from_date').on('keyup', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {

                    $('#from_date').val($('#buff_date').val());
                } else $('#buff_date').val($('#from_date').val());
            });

            $('#to_date').on('keyup', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {

                    $('#to_date').val($('#buff_date').val());
                } else $('#buff_date').val($('#to_date').val());
            });

            $('#from_date_execution').on('keyup', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {

                    $('#from_date_execution').val($('#buff_date_execution').val());
                } else $('#buff_date_execution').val($('#from_date_execution').val());
            });

            $('#to_date_execution').on('keyup', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {

                    $('#to_date_execution').val($('#buff_date_execution').val());
                } else $('#buff_date_execution').val($('#to_date_execution').val());
            });

        });
    </script>
</body>

</html>