<?php
$config = array(
	'config' => array(
		array(
			'field' => 'status','label' => 'Tình trạng',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'advertise','label' => 'Quảng cáo',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'reason','label' => 'Lý do',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'contact','label' => 'Địa chỉ',
			'rules' => 'trim|required|min_length[3]|max_length[50]'
		),
		array(
			'field' => 'phone','label' => 'Phone',
			'rules' => 'trim|required|min_length[8]'
		),
		array(
			'field' => 'ck','label' => 'Liên hệ',
			'rules' => 'trim|required|min_length[10]'
		),
		array(
			'field' => 'ckt','label' => 'Chuyển khoản trước',
			'rules' => 'trim|required|min_length[10]'
		),array(
			'field' => 'cks','label' => 'Chuyển khoản sau',
			'rules' => 'trim|required|min_length[10]'
		),array(
			'field' => 'gnh','label' => 'Gửi & nhận hàng',
			'rules' => 'trim|required|min_length[10]'
		),array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		),array(
			'field' => 'tax_code','label' => 'Tax Code',
			'rules' => 'trim|required|min_length[5]'
		),array(
			'field' => 'email','label' => 'Email',
			'rules' => 'trim|required|email'
		)
	),
	'login' => array(
		array(
			'field' => 'user','label' => 'Username',
			'rules' => 'trim|required|min_length[3]|max_length[25]'
		),array(
			'field' => 'pass','label' => 'Password',
			'rules' => 'trim|required|min_length[3]|max_length[32]'
		),array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'userEdit' => array(
		array(
			'field' => 'pass','name' => 'Mật khẩu',
			'rules' =>  'trim|required|min_length[3]|max_length[32]'
		),array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'ajaxDo' => array(
		array(
			'field' => 'id','label' => 'Id',
			'rules' => 'trim|required|is_natural'
		),
		array(
			'field' => 'status','label' => 'Status',
			'rules' => 'required|trim|is_natural'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'productAdd' => array(
		array(
			'field' => 'name','label' => 'Tên sản phẩm',
			'rules' => 'trim|required|max_length[200]'
		),
		array(
			'field' => 'category','label' => 'Chủng loại',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'tag','label' => 'SEO',
			'rules' => 'trim|max_length[300]'
		),
		array(
			'field' => 'thumb','label' => 'Hình đại diện',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'price','label' => 'Giá',
			'rules' => 'trim|required|numeric|greater_than[1]'
		),
		array(
			'field' => 'sale','label' => 'Sale',
			'rules' => 'trim|required|less_than[100]|greater_than[-1]'
		),
		array(
			'field' => 'hot','label' => 'Sản phẩm hot',
			'rules' => 'trim|requred|isBool'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'productEdit' => array(
		array(
			'field' => 'id','label' => 'ID',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'name','label' => 'Tên sản phẩm',
			'rules' => 'trim|required|max_length[200]'
		),
		array(
			'field' => 'category','label' => 'Chủng loại',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'thumb','label' => 'Hình đại diện',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'tag','label' => 'SEO',
			'rules' => 'trim|max_length[300]'
		),
		array(
			'field' => 'price','label' => 'Giá',
			'rules' => 'trim|required|numeric|greater_than[1]'
		),
		array(
			'field' => 'hot','label' => 'Sản phẩm hot',
			'rules' => 'trim|requred|isBool'
		),
		array(
			'field' => 'sale','label' => 'Sale',
			'rules' => 'trim|required|less_than[100]|greater_than[-1]'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'categoryAdd' => array(
		array(
			'field' => 'name','label' => 'Tên chủng loại',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'parent','label' => 'Chủng loại cha',
			'rules' => 'trim|required|is_natural'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'categorySave' => array(
		array(
			'field' => 'category','label' => 'Chủng loại',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'delete' => array(
		array(
			'field' => 'id','label' => 'ID',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'categoryEdit' => array(
		array(
			'field' => 'id','label' => 'ID',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'name','label' => 'Tên chủng loại',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'parent','label' => 'Chủng loại cha',
			'rules' => 'trim|required|is_natural'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'tipAdd' => array(
		array(
			'field' => 'name','label' => 'Tên bí kíp',
			'rules' => 'trim|required|min_length[3]|max_length[200]'
		),
		array(
			'field' => 'thumb','label' => 'Hình đại diện',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'review','label' => 'Review',
			'rules' => 'trim|required|min_length[5]|max_length[200]'
		),
		array(
			'field' => 'detail','label' => 'Chi tiết',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'tipEdit' => array(
		array(
			'field' => 'id','label' => 'ID',
			'rules' => 'trim|required|is_natural_no_zero'
		),
		array(
			'field' => 'name','label' => 'Tên bí kíp',
			'rules' => 'trim|required|min_length[3]|max_length[200]'
		),
		array(
			'field' => 'thumb','label' => 'Hình đại diện',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'review','label' => 'Review',
			'rules' => 'trim|required|min_length[5]|max_length[200]'
		),
		array(
			'field' => 'detail','label' => 'Chi tiết',
			'rules' => 'trim|required|min_length[5]'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
	'galleryList' => array(
		array(
			'field' => 'img','label' => 'Image',
			'rules' => 'trim|required'
		)
	),
	'advertise' => array(
		array(
			'field' => 'link','label' => 'Link',
			'rules' => 'trim'
		),
		array(
			'field' => 'img','label' => 'Hình ảnh',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'active','label' => 'Tình trạng',
			'rules' => 'trim|required|is_natural'
		),
		array(
			'field' => 'captcha','label' => 'Captcha',
			'rules' => 'trim|required|captcha'
		)
	),
    'productOrder' => array(
        array(
            'field' => 'name',
            'label' => 'Họ tên',
            'rules' => 'trim|required|max_length[255]'
        ),
        array(
            'field' => 'address',
            'label' => 'Địa chỉ',
            'rules' => 'trim|required|max_length[200]'
        ),
        array(
            'field' => 'phone',
            'label' => 'Số ĐT',
            'rules' => 'trim|required|numeric|max_length[255]'
        )
    ),
    'policyAdd' => array(
        array(
            'field' => 'name',
            'label' => 'Tên Chính sách',
            'rules' => 'trim|required|max_length[255]'
        ),
        array(
            'field' => 'link',
            'label' => 'Đường Dẫn',
            'rules' => 'trim|required|max_length[255]'
        ),
        array(
			'field' => 'status','label' => 'Trạng Thái',
			'rules' => 'required|is_natural'
		),
    ),
    'policyEdit' => array(
    	array(
			'field' => 'id','label' => 'ID',
			'rules' => 'trim|required|is_natural_no_zero'
		),
        array(
            'field' => 'name',
            'label' => 'Tên Chính sách',
            'rules' => 'trim|required|max_length[255]'
        ),
        array(
            'field' => 'link',
            'label' => 'Đường Dẫn',
            'rules' => 'trim|required|max_length[255]'
        ),
        array(
			'field' => 'status','label' => 'Trạng Thái',
			'rules' => 'required|is_natural'
		),
    )
);