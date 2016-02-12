<?php

class M_parameter extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_batchType()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'IS_ACTIVE' => $this->input->post('IS_ACTIVE'),
            'IS_BATCH_REPORT' => $this->input->post('IS_BATCH_REPORT'),
            'UPDATE_DATE' => "SYSDATE",
            'UPDATE_BY' => $this->session->userdata('d_user_name')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_BATCH_TYPE_ID', 'P_BATCH_TYPE');
                $this->db->query("INSERT INTO P_BATCH_TYPE(P_BATCH_TYPE_ID,CODE,IS_ACTIVE,IS_BATCH_REPORT,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATE_BY)
                                    VALUES($new_id,
                                            '" . $this->input->post('CODE') . "',
                                            '" . $this->input->post('IS_ACTIVE') . "',
                                            '" . $this->input->post('IS_BATCH_REPORT') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_BATCH_TYPE SET
                                    CODE = '" . $this->input->post('CODE') . "',
                                    IS_ACTIVE = '" . $this->input->post('IS_ACTIVE') . "',
                                    IS_BATCH_REPORT = '" . $this->input->post('IS_BATCH_REPORT') . "',
                                    UPDATE_DATE = SYSDATE,
                                    UPDATE_BY = '" . $this->session->userdata('d_user_name') . "'
                                    WHERE
                                    P_BATCH_TYPE_ID = " . $id_);
                break;
            case 'del':
                $this->db->where('P_BATCH_TYPE_ID', $id_);
                $this->db->delete('P_BATCH_TYPE');
                break;
        }

    }


    function crud_reference()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'REFERENCE_NAME' => $this->input->post('REFERENCE_NAME'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_REFERENCE_TYPE_ID', 'P_REFERENCE_TYPE');
                $this->db->query("INSERT INTO P_REFERENCE_TYPE(P_REFERENCE_TYPE_ID,CODE,REFERENCE_NAME,DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES($new_id,
                                            '" . $this->input->post('CODE') . "',
                                            '" . $this->input->post('REFERENCE_NAME') . "',
                                            '" . $this->input->post('DESCRIPTION') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_REFERENCE_TYPE SET
                                    CODE = '" . $this->input->post('CODE') . "',
                                    REFERENCE_NAME = '" . $this->input->post('REFERENCE_NAME') . "',
                                    DESCRIPTION = '" . $this->input->post('DESCRIPTION') . "',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '" . $this->session->userdata('d_user_name') . "'
                                    WHERE
                                    P_REFERENCE_TYPE_ID = " . $id_);
                break;
            case 'del':
                $this->db->where('P_REFERENCE_TYPE_ID', $id_);
                $this->db->delete('P_REFERENCE_TYPE');
                break;
        }

    }

    function crud_reference_list()
    {
        $parent_id = $this->input->post('PARENT_ID');
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'REFERENCE_NAME' => $this->input->post('REFERENCE_NAME'),
            'LISTING_NO' => $this->input->post('LISTING_NO'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_REFERENCE_LIST_ID', 'P_REFERENCE_LIST');
                $this->db->query("INSERT INTO P_REFERENCE_LIST(P_REFERENCE_LIST_ID,P_REFERENCE_TYPE_ID,CODE,REFERENCE_NAME,LISTING_NO,DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES(" . $new_id . "," . $parent_id . ",
                                            '" . $this->input->post('CODE') . "',
                                            '" . $this->input->post('REFERENCE_NAME') . "',
											'" . $this->input->post('LISTING_NO') . "',
                                            '" . $this->input->post('DESCRIPTION') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_REFERENCE_LIST SET
                                    CODE = '" . $this->input->post('CODE') . "',
                                    REFERENCE_NAME = '" . $this->input->post('REFERENCE_NAME') . "',
									LISTING_NO = '" . $this->input->post('LISTING_NO') . "',
                                    DESCRIPTION = '" . $this->input->post('DESCRIPTION') . "',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '" . $this->session->userdata('d_user_name') . "'
                                    WHERE
                                    P_REFERENCE_LIST_ID = " . $id_);
                break;
            case 'del':
                $this->db->where('P_REFERENCE_LIST_ID', $id_);
                $this->db->delete('P_REFERENCE_LIST');
                break;
        }

    }


    function crud_user_attribute_type()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $result = array();

        switch ($oper) {
            case 'add':
                try {
                    $new_id = gen_id('P_USER_ATTRIBUTE_TYPE_ID', 'P_USER_ATTRIBUTE_TYPE');
                    $db_result = $this->db->query_custom("INSERT INTO P_USER_ATTRIBUTE_TYPE(P_USER_ATTRIBUTE_TYPE_ID,CODE,VALID_FROM,VALID_TO, DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                        VALUES($new_id,
                                                '" . $this->input->post('CODE') . "',
                                                to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                                to_date('" . $this->input->post('VALID_TO') . "','dd/mm/yyyy'),
                                                '" . $this->input->post('DESCRIPTION') . "',
                                                SYSDATE,
                                                '" . $this->session->userdata('d_user_name') . "',
                                                SYSDATE,
                                                '" . $this->session->userdata('d_user_name') . "'
                                                )");


                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');

                     }
                     
                     $result['success'] = true;
                     $result['message'] = 'Data berhasil ditambahkan';                       
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }

                echo json_encode($result);
                exit;

                break;
            case 'edit':
                try {
                    $db_result = $this->db->query_custom("UPDATE P_USER_ATTRIBUTE_TYPE SET
                                        CODE = '" . $this->input->post('CODE') . "',
                                        VALID_FROM = to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                        VALID_TO = to_date('" . $this->input->post('VALID_TO') . "','dd/mm/yyyy'),
                                        DESCRIPTION = '" . $this->input->post('DESCRIPTION') . "',
                                        UPDATED_DATE = SYSDATE,
                                        UPDATED_BY = '" . $this->session->userdata('d_user_name') . "'
                                        WHERE
                                        P_USER_ATTRIBUTE_TYPE_ID = " . $id_);
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                echo json_encode($result);
                exit;
                
                break;
            case 'del':
                $this->db->where('P_USER_ATTRIBUTE_TYPE_ID', $id_);
                $this->db->delete('P_USER_ATTRIBUTE');

                $this->db->where('P_USER_ATTRIBUTE_TYPE_ID', $id_);
                $this->db->delete('P_USER_ATTRIBUTE_LIST');

                $this->db->where('P_USER_ATTRIBUTE_TYPE_ID', $id_);
                $this->db->delete('P_USER_ATTRIBUTE_TYPE');
                break;
        }

    }


    function crud_user_attribute_list()
    {
        $parent_id = $this->input->post('PARENT_ID');
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        switch ($oper) {
            case 'add':
                try {
                    $new_id = gen_id('P_USER_ATTRIBUTE_LIST_ID', 'P_USER_ATTRIBUTE_LIST');
                    $db_result = $this->db->query_custom("INSERT INTO P_USER_ATTRIBUTE_LIST(P_USER_ATTRIBUTE_LIST_ID,P_USER_ATTRIBUTE_TYPE_ID, CODE, NAME, VALID_FROM,VALID_TO, DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                        VALUES(" . $new_id . "," . $parent_id . ",
                                                '" . $this->input->post('CODE') . "',
                                                '" . $this->input->post('NAME') . "',
                                                to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                                to_date('" . $this->input->post('VALID_TO') . "','dd/mm/yyyy'),
                                                '" . $this->input->post('DESCRIPTION') . "',
                                                SYSDATE,
                                                '" . $this->session->userdata('d_user_name') . "',
                                                SYSDATE,
                                                '" . $this->session->userdata('d_user_name') . "'
                                                )");
                    
                     if($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                     }
                     
                     $result['success'] = true;
                     $result['message'] = 'Data berhasil ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                echo json_encode($result);
                exit;
                
                break;
            case 'edit':
                try {
                    
                    $db_result = $this->db->query_custom("UPDATE P_USER_ATTRIBUTE_LIST SET
                                        CODE = '" . $this->input->post('CODE') . "',
                                        NAME = '" . $this->input->post('NAME') . "',
                                        VALID_FROM = to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                        VALID_TO = to_date('" . $this->input->post('VALID_TO') . "','dd/mm/yyyy'),
                                        DESCRIPTION = '" . $this->input->post('DESCRIPTION') . "',
                                        UPDATED_DATE = SYSDATE,
                                        UPDATED_BY = '" . $this->session->userdata('d_user_name') . "'
                                        WHERE
                                        P_USER_ATTRIBUTE_LIST_ID = " . $id_);
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }
                     
                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';
                    
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                echo json_encode($result);
                exit;
                
                break;
            case 'del':
                $this->db->where('P_USER_ATTRIBUTE_LIST_ID', $id_);
                $this->db->delete('P_USER_ATTRIBUTE');

                $this->db->where('P_USER_ATTRIBUTE_LIST_ID', $id_);
                $this->db->delete('P_USER_ATTRIBUTE_LIST');

                break;
        }

    }


    function crud_cust_pgl()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        switch ($oper) {
            case 'add':
                try {
                    $new_id = gen_id('PGL_ID','CUST_PGL');
                    $db_result = $this->db->query_custom("INSERT INTO CUST_PGL(PGL_ID,PGL_NAME,PGL_ADDR,PGL_CONTACT_NO,ENABLE_FEE)
                                        VALUES($new_id,
                                                '".$this->input->post('PGL_NAME')."',
                                                '".$this->input->post('PGL_ADDR')."',
                                                '".$this->input->post('PGL_CONTACT_NO')."',
                                                '".$this->input->post('ENABLE_FEE')."')");
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }
                     
                    $result['success'] = true;
                    $result['message'] = 'Data berhasil ditambahkan';
                
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();        
                }
                
                echo json_encode($result);
                exit;
                
                break;
            case 'edit':
                try {
                    $db_result = $this->db->query_custom("UPDATE CUST_PGL SET
                                        PGL_NAME = '".$this->input->post('PGL_NAME')."',
                                        PGL_ADDR = '".$this->input->post('PGL_ADDR')."',
                                        PGL_CONTACT_NO = '".$this->input->post('PGL_CONTACT_NO')."',
                                        ENABLE_FEE = '".$this->input->post('ENABLE_FEE')."'
                                        WHERE PGL_ID = ".$id_ );
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }
                     
                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();   
                }
                echo json_encode($result);
                exit;
                
                break;
            case 'del':

                $this->db->where('PGL_ID', $id_);
                $this->db->delete('PGL_TEN');

                $this->db->where('PGL_ID', $id_);
                $this->db->delete('CUST_PGL');
                break;
        }

    }


    function crud_cust_ten()
    {

        $parent_id = $this->input->post('PARENT_ID');
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        switch ($oper) {
            case 'add':
                $new_id = gen_id('TEN_ID', 'CUST_TEN');
                $this->db->query("INSERT INTO CUST_TEN(TEN_ID,NCLI,TEN_NAME,TEN_ADDR,TEN_CONTACT_NO)
                                    VALUES($new_id,
                                            '" . $this->input->post('NCLI') . "',
                                            '" . $this->input->post('TEN_NAME') . "',
                                            '" . $this->input->post('TEN_ADDR') . "',
                                            '" . $this->input->post('TEN_CONTACT_NO') . "')");


                $this->db->query("INSERT INTO PGL_TEN(PGL_ID, TEN_ID) VALUES(" . $parent_id . "," . $new_id . ")");
                break;
            case 'edit':
                $this->db->query("UPDATE CUST_TEN SET
                                    NCLI = '" . $this->input->post('NCLI') . "',
                                    TEN_NAME = '" . $this->input->post('TEN_NAME') . "',
                                    TEN_ADDR = '" . $this->input->post('TEN_ADDR') . "',
                                    TEN_CONTACT_NO = '" . $this->input->post('TEN_CONTACT_NO') . "'
                                    WHERE TEN_ID = " . $id_);
                break;
            case 'del':

                $this->db->where('TEN_ID', $id_);
                $this->db->delete('PGL_TEN');

                $this->db->where('TEN_ID', $id_);
                $this->db->delete('TEN_ND');

                $this->db->where('TEN_ID', $id_);
                $this->db->delete('TEN_ND_NONPOTS');

                $this->db->where('TEN_ID', $id_);
                $this->db->delete('CUST_TEN');
                break;
        }

    }

    function crud_pic()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $array_edit = array('PIC_NAME' => $this->input->post('PIC_NAME'),
            'JABATAN' => $this->input->post('JABATAN'),
            'ADDRESS_1' => $this->input->post('ADDRESS_1'),
            'ADDRESS_2' => $this->input->post('ADDRESS_2'),
            'KOTA' => $this->input->post('KOTA'),
            'ZIP_CODE' => $this->input->post('ZIP_CODE'),
            'EMAIL' => $this->input->post('EMAIL'),
            'NO_HP' => $this->input->post('NO_HP'),
            'NO_TELP' => $this->input->post('NO_TELP'),
            'FAX' => $this->input->post('FAX'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION'),
            'VALID_FROM' => $this->input->post('VALID_FROM'),
            'VALID_UNTIL' => $this->input->post('VALID_UNTIL')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_PIC_ID', 'P_PIC');
                $this->db->query("INSERT INTO P_PIC(P_PIC_ID, 
											PIC_NAME, 
											JABATAN, 
											ADDRESS_1, 
											ADDRESS_2, 
											KOTA, 
											ZIP_CODE, 
											EMAIL, 
											NO_HP, 
											NO_TELP, 
											FAX, 
											DESCRIPTION, 
											UPDATED_DATE, 
											UPDATED_BY, 
											VALID_FROM, 
											VALID_UNTIL)
                                    VALUES($new_id,
                                            '" . $this->input->post('PIC_NAME') . "',
                                            '" . $this->input->post('JABATAN') . "',
                                            '" . $this->input->post('ADDRESS_1') . "',
											'" . $this->input->post('ADDRESS_2') . "',
											'" . $this->input->post('KOTA') . "',
											" . $this->input->post('ZIP_CODE') . ",
											'" . $this->input->post('EMAIL') . "',
											'" . $this->input->post('NO_HP') . "',
											'" . $this->input->post('NO_TELP') . "',
											'" . $this->input->post('FAX') . "',
											'" . $this->input->post('DESCRIPTION') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "',
                                            to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
											to_date('" . $this->input->post('VALID_UNTIL') . "','dd/mm/yyyy')
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_PIC SET
                                    PIC_NAME='" . $this->input->post('PIC_NAME') . "',
									JABATAN='" . $this->input->post('JABATAN') . "',
									ADDRESS_1='" . $this->input->post('ADDRESS_1') . "',
									ADDRESS_2='" . $this->input->post('ADDRESS_2') . "',
									KOTA='" . $this->input->post('KOTA') . "',
									ZIP_CODE=" . $this->input->post('ZIP_CODE') . ",
									EMAIL='" . $this->input->post('EMAIL') . "',
									NO_HP='" . $this->input->post('NO_HP') . "',
									NO_TELP='" . $this->input->post('NO_TELP') . "',
									FAX='" . $this->input->post('FAX') . "',
									DESCRIPTION='" . $this->input->post('DESCRIPTION') . "',
									UPDATED_DATE=SYSDATE,
									UPDATED_BY='" . $this->session->userdata('d_user_name') . "',
									VALID_FROM = to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                    VALID_UNTIL = to_date('" . $this->input->post('VALID_UNTIL') . "','dd/mm/yyyy')
                                    WHERE
                                    P_PIC_ID = " . $id_);
                break;
            case 'del':
                $this->db->where('P_PIC_ID', $id_);
                $this->db->delete('P_PIC');
                break;
        }

    }

    function crud_DAT_AM()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $array_edit = array('AM_NAME' => $this->input->post('AM_NAME'),
            'NIK' => $this->input->post('NIK'),
            'ADDRESS_1' => $this->input->post('ADDRESS_1'),
            'ADDRESS_2' => $this->input->post('ADDRESS_2'),
            'KOTA' => $this->input->post('KOTA'),
            'ZIP_CODE' => $this->input->post('ZIP_CODE'),
            'EMAIL' => $this->input->post('EMAIL'),
            'NO_HP' => $this->input->post('NO_HP'),
            'NO_TELP' => $this->input->post('NO_TELP'),
            'FAX' => $this->input->post('FAX'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION'),
            'VALID_FROM' => $this->input->post('VALID_FROM'),
            'VALID_UNTIL' => $this->input->post('VALID_UNTIL')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_DAT_AM_ID', 'P_DAT_AM');
                $this->db->query("INSERT INTO P_DAT_AM(P_DAT_AM_ID, 
											AM_NAME, 
											NIK, 
											ADDRESS_1, 
											ADDRESS_2, 
											KOTA, 
											ZIP_CODE, 
											EMAIL, 
											NO_HP, 
											NO_TELP, 
											FAX, 
											DESCRIPTION, 
											UPDATED_DATE, 
											UPDATED_BY, 
											VALID_FROM, 
											VALID_UNTIL)
                                    VALUES($new_id,
                                            '" . $this->input->post('AM_NAME') . "',
                                            '" . $this->input->post('NIK') . "',
                                            '" . $this->input->post('ADDRESS_1') . "',
											'" . $this->input->post('ADDRESS_2') . "',
											'" . $this->input->post('KOTA') . "',
											" . $this->input->post('ZIP_CODE') . ",
											'" . $this->input->post('EMAIL') . "',
											'" . $this->input->post('NO_HP') . "',
											'" . $this->input->post('NO_TELP') . "',
											'" . $this->input->post('FAX') . "',
											'" . $this->input->post('DESCRIPTION') . "',
                                            SYSDATE,
                                            '" . $this->session->userdata('d_user_name') . "',
                                            to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
											to_date('" . $this->input->post('VALID_UNTIL') . "','dd/mm/yyyy')
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_DAT_AM SET
                                    AM_NAME='" . $this->input->post('AM_NAME') . "',
									NIK='" . $this->input->post('NIK') . "',
									ADDRESS_1='" . $this->input->post('ADDRESS_1') . "',
									ADDRESS_2='" . $this->input->post('ADDRESS_2') . "',
									KOTA='" . $this->input->post('KOTA') . "',
									ZIP_CODE=" . $this->input->post('ZIP_CODE') . ",
									EMAIL='" . $this->input->post('EMAIL') . "',
									NO_HP='" . $this->input->post('NO_HP') . "',
									NO_TELP='" . $this->input->post('NO_TELP') . "',
									FAX='" . $this->input->post('FAX') . "',
									DESCRIPTION='" . $this->input->post('DESCRIPTION') . "',
									UPDATED_DATE=SYSDATE,
									UPDATED_BY='" . $this->session->userdata('d_user_name') . "',
									VALID_FROM = to_date('" . $this->input->post('VALID_FROM') . "','dd/mm/yyyy'),
                                    VALID_UNTIL = to_date('" . $this->input->post('VALID_UNTIL') . "','dd/mm/yyyy')
                                    WHERE
                                    P_DAT_AM_ID = " . $id_);
                break;
            case 'del':
                $this->db->where('P_DAT_AM_ID', $id_);
                $this->db->delete('P_DAT_AM');
                break;
        }
    }

    public function crud_fastel()
    {
        $this->db->_protect_identifiers = false;
        $this->db->protect_identifiers('TEN_ND', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "TEN_ND";
        $ND = $this->input->post('ND');
        $AKTIF = $this->input->post('AKTIF');
        $TEN_ID = $this->input->post('TEN_ID');
        $CREATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_TO = $this->input->post('VALID_TO');

        $data = array('ND' => $ND,
            'AKTIF' => $AKTIF,
            'TEN_ID' => $TEN_ID,
            'CREATED_DATE' => $CREATED_DATE,
            'CREATED_BY' => $CREATED_BY,
            'VALID_FROM' => $VALID_FROM,
            'VALID_TO' => $VALID_TO
        );

        switch ($oper) {
            case 'add':
                // $this->db->set('CREATED_DATE', 'SYSDATE', FALSE);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where('ND', $ND);
                $this->db->where('TEN_ID', $TEN_ID);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('ND', $ND);
                $this->db->where('TEN_ID', $TEN_ID);
                $this->db->delete($table);
                break;
        }

    }

    public function insertFastel($data)
    {
        $this->db->_protect_identifiers = false;
        $this->db->insert('TEN_ND', $data);
        return $this->db->affected_rows();
    }

    public function deleteFastelByTenant($ten_id)
    {
        $this->db->where('TEN_ID', $ten_id);
        $this->db->delete('TEN_ND');
    }
}