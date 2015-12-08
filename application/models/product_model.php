<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public $view = 0;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function getData()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'cid' => $this->input->post('category'),
            'thumb' => $this->input->post('thumb'),
            'image' => strip_tags(implode(',', $this->input->post('image'))),
            'seo' => strip_tags($this->input->post('tag')),
            'price' => $this->input->post('price'),
            'sale' => $this->input->post('sale'),
            'start' => $this->input->post('start'),
            'hot' => $this->input->post('hot'),
            'end' => $this->input->post('end'),
            'date' => date('Y-m-d H:i:s', time()),
            'status' => 1,
            'available' => $this->input->post('available'),
        );

        //ki tu dac biet bi xss_clean mat bbcode
        $data['advantage'] = html_escape($this->input->get_advantage());
        $this->load->helper('security');
        $data['advantage'] = xss_clean($data['advantage']);

        if (!empty($data['start']))
            $data['start'] = date('Y-m-d', strtotime($data['start']));

        if (!empty($data['end']))
            $data['end'] = date('Y-m-d', strtotime($data['end']));

        return $data;
    }

    public function relative($cid, $id)
    {
        $this->db->select('id, name, thumb');

        $this->db->where('cid', $cid);
        $this->db->where('id !=', $id);

        $this->db->limit(15);

        return $this->db->get('product')->result();
    }

    public function add()
    {
        $data = $this->getData();

        return $this->db->insert('product', $data);
    }

    public function edit()
    {
        $data = $this->getData();

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('product', $data);
    }

    public function delete()
    {
        $this->db->where('id', $this->input->post('id'));
        return $this->db->delete('product');
    }

    public function select($table, $id, $rule, $field = '*')
    {
        if (!$this->view):
            $this->db->set('view', 'view+1', false);
            $this->db->where('id', $id);
            $this->db->update($table);

            $this->input->set_cookie(array(
                'name' => 'product_' . $id,
                'value' => true, 'expire' => '3600'
            ));
            $this->view = 0;
        endif;

        $this->db->where($rule, $id);
        $this->db->select($field);
        $this->db->limit(1);

        return $this->db->get($table)->row();
    }

    public function selectAll($table, $id, $rule, $field = '*')
    {
        $this->db->where($rule, $id);
        $this->db->select($field);

        return $this->db->get($table)->result();
    }
}