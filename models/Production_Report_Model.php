<?php

class Production_Report_Model extends CI_Model
{
    public function __construct()
    {
        $this->user_table_orders = "orders_";
        $this->user_table_samples = "samples_";
    }

    public function get_samples_report(
        $company_id,
        $type = null,
        $fineness = null,
        $composition = null,
        $metric_number = null,
        $clients = null,
        $sample_details = null,
        $from_date_execution = null,
        $to_date_execution = null,
        $in_charge = null,
        $in_charge_client = null,
        $in_charge_confection = null,
        $name = null,
        $from_date = null,
        $to_date = null,
        $order_by = null,
        $ref_clients = null
    ) {

        $select_fields = 'ssd.request_date, s.company_type, s.client_reference, s.fineness, sd.type, ssd.no_of_pieces, ssd.done_pieces';

        // Add specific fields based on $type
        if ($type === '1') {
            $select_fields .= ', sc.name, sc.composition, sc.metric_number, s.in_charge, s.in_charge_confection, s.in_charge_client, s.expiry_date';
        } elseif ($type === '2') {
            // No additional fields needed for type 2
            $select_fields .= '';
        } elseif ($type === '3') {
            $select_fields .= ', s.in_charge, s.in_charge_confection, s.in_charge_client, s.expiry_date, ssd.done_date';
        } elseif ($type === '4') {
            $select_fields .= ', sc.name, sc.composition, sc.metric_number, ssd.sample_done';
        } elseif ($type === '5') {
            $select_fields .= ', s.in_charge, s.in_charge_confection, s.expiry_date, o.delivery_time, st.name, st.date_modified as startup_date, st.id_order as order_id, st.id as startup_id, o.id_sample as sample_id';
        } else {
            // Include all fields for other cases
            $select_fields = 's.id, s.company_type, s.company_id, s.client_reference, sc.name, sc.composition, sc.metric_number, 
                      s.fineness, ssd.id_samplers_details, ssd.no_of_pieces, s.expiry_date, s.in_charge, 
                      s.in_charge_client, s.in_charge_confection, sd.type, ssd.request_date, ssd.expedition_date, 
                      ssd.done_date, ssd.done_pieces, ssd.delivered_pieces, ssd.sample_done';
        }

        // Apply the SELECT fields to the query
        $this->db->select($select_fields);

        $this->db->from("samples_$company_id s");
        $this->db->join('samples_samplers_details ssd', 's.id = ssd.id_sample', 'left');
        $this->db->join('samplers_details sd', 'sd.id = ssd.id_samplers_details', 'left');
        if ($type === '1' || $type === '4') {
            $this->db->join('sample_composition sc', 'sc.id_sample_details = ssd.id', 'left');
        }
        if ($type === '5') {
            $this->db->join("orders_$company_id o", "o.id_sample = s.id", "left");
            $this->db->join("startups_$company_id st", "st.id_order = o.id", "left");
            $this->db->where("o.active", 1);
            $this->db->where("st.active", 1);
            $this->db->where("st.id_order >", 0);
            $this->db->where("st.id >", 0);
        }
        $this->db->where('s.active_sample', 1);
        $this->db->where('sd.active', 1);
        $this->db->where('sd.company_id', $company_id);
        $this->db->where('ssd.company_id', $company_id);
        if ($type === '3') {
            $this->db->where('ssd.done_date !=', '0000-00-00');
        } else {
            $this->db->where('ssd.request_date !=', '0000-00-00');
        }
        if ($type === '1') {
            $this->db->where('ssd.no_of_pieces > COALESCE(ssd.done_pieces, 0)');
        }

        if ($type === '1' || $type === '4') {
            $this->db->where('sc.company_id', $company_id);
            $this->db->where('sc.id_sample_details >', 0);
        }

        if ($from_date != null) {
            if ($type === '3') {
                $this->db->where('ssd.done_date >=', $from_date);
            } else if ($type === '5') {
                $this->db->where('st.date_modified >=', $from_date);
                $this->db->where('ssd.request_date >=', $from_date);
            } else {
                $this->db->where('ssd.request_date >=', $from_date);
            }
        }

        if ($to_date != null) {
            if ($type === '3') {
                $this->db->where('ssd.done_date <=', $to_date);
            } elseif ($type === '5') {
                $this->db->where('st.date_modified <=', $to_date);
            } else {
                $this->db->where('ssd.request_date <=', $to_date);
            }
        }

        if ($from_date_execution != null) {
            if ($type === '5') {
                $this->db->where('o.delivery_time >=', $from_date_execution);
            } else {
                $this->db->where('s.expiry_date >=', $from_date_execution);
            }
        }

        if ($to_date_execution != null) {
            if ($type === '5') {
                $this->db->where('o.delivery_time <=', $to_date_execution);
            } else {
                $this->db->where('s.expiry_date <=', $to_date_execution);
            }
        }

        if ($fineness != null) {
            if (is_array($fineness)) {
                $this->db->where_in('s.fineness', $fineness);
            } else {
                $this->db->where('s.fineness', $fineness);
            }
        }
        if ($composition != null) {
            if (is_array($composition)) {
                $this->db->where_in('sc.composition', $composition);
            } else {
                $this->db->where('sc.composition', $composition);
            }
        }
        if ($metric_number != null) {
            if (is_array($metric_number)) {
                $this->db->where_in('sc.metric_number', $metric_number);
            } else {
                $this->db->where('sc.metric_number', $metric_number);
            }
        }
        if ($clients != null) {
            if (is_array($clients)) {
                $this->db->where_in('s.company_type', $clients);
            } else {
                $this->db->where('s.company_type', $clients);
            }
        }
        if ($sample_details != null) {
            if (is_array($sample_details)) {
                $this->db->where_in('sd.type', $sample_details);
            } else {
                $this->db->where('sd.type', $sample_details);
            }
        }
        // if ($expiry_date != null) {
        //     if (is_array($expiry_date)) {
        //         $this->db->where_in('s.expiry_date', $expiry_date);
        //     } else {
        //         $this->db->where('s.expiry_date', $expiry_date);
        //     }
        // }
        if ($in_charge != null) {
            if (is_array($in_charge)) {
                $this->db->where_in('s.in_charge', $in_charge);
            } else {
                $this->db->where('s.in_charge', $in_charge);
            }
        }
        if ($in_charge_client != null) {
            if (is_array($in_charge_client)) {
                $this->db->where_in('s.in_charge_client', $in_charge_client);
            } else {
                $this->db->where('s.in_charge_client', $in_charge_client);
            }
        }
        if ($in_charge_confection != null) {
            if (is_array($in_charge_confection)) {
                $this->db->where_in('s.in_charge_confection', $in_charge_confection);
            } else {
                $this->db->where('s.in_charge_confection', $in_charge_confection);
            }
        }
        if ($name != null) {
            if (is_array($name)) {
                $this->db->where_in('sc.name', $name);
            } else {
                $this->db->where('sc.name', $name);
            }
        }

        if ($ref_clients != null) {
            if (is_array($ref_clients)) {
                $this->db->where_in('s.client_reference', $ref_clients);
            } else {
                $this->db->where('s.client_reference', $ref_clients);
            }
        }

        if ($order_by === 'total_per_in_charge_confection') {
            $this->db->order_by('s.in_charge_confection', 'ASC');
        } elseif ($order_by === 'total_per_in_charge') {
            $this->db->order_by('s.in_charge', 'ASC');
        } else {
            $this->db->order_by('s.company_type', 'ASC');
            $this->db->order_by('s.client_reference', 'ASC');
            $this->db->order_by('sd.type', 'ASC');
            $this->db->order_by('s.fineness', 'ASC');
            // if ($type === '5') {
            //     $this->db->order_by('st.date_modified', 'DESC');
            // } else {
            //     $this->db->order_by('ssd.request_date', 'DESC');
            // }
        }

        $query = $this->db->get();
        return $query->result_array();
    }
}