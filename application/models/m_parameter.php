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
                } catch (Exception $e) {
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

                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }

                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';

                } catch (Exception $e) {
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

                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }

                    $result['success'] = true;
                    $result['message'] = 'Data berhasil ditambahkan';

                } catch (Exception $e) {
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

                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }

                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';


                } catch (Exception $e) {
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
                    $new_id = gen_id('PGL_ID', 'CUST_PGL');
                    $db_result = $this->db->query_custom("INSERT INTO CUST_PGL(PGL_ID,PGL_NAME,PGL_ADDR,PGL_CONTACT_NO,ENABLE_FEE)
                                        VALUES($new_id,
                                                '" . $this->input->post('PGL_NAME') . "',
                                                '" . $this->input->post('PGL_ADDR') . "',
                                                '" . $this->input->post('PGL_CONTACT_NO') . "',
                                                '" . $this->input->post('ENABLE_FEE') . "')");

                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }

                    $result['success'] = true;
                    $result['message'] = 'Data berhasil ditambahkan';

                } catch (Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }

                echo json_encode($result);
                exit;

                break;
            case 'edit':
                try {
                    $db_result = $this->db->query_custom("UPDATE CUST_PGL SET
                                        PGL_NAME = '" . $this->input->post('PGL_NAME') . "',
                                        PGL_ADDR = '" . $this->input->post('PGL_ADDR') . "',
                                        PGL_CONTACT_NO = '" . $this->input->post('PGL_CONTACT_NO') . "',
                                        ENABLE_FEE = '" . $this->input->post('ENABLE_FEE') . "'
                                        WHERE PGL_ID = " . $id_);

                    if ($db_result != 1) {
                        throw new Exception('Terjadi duplikasi data');
                    }

                    $result['success'] = true;
                    $result['message'] = 'Data berhasil diupdate';

                } catch (Exception $e) {
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

    public function crud_detailmitra()
    {
        $this->db->_protect_identifiers = false;

        $table = "P_MAP_MIT_CC";
        $pk = "P_MAP_MIT_CC_ID";

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $p_map_mit_cc = $this->input->post("p_map_mit_cc");
        $cc_id = $this->input->post("cc_id");
        $mitra_id = $this->input->post("mitra_id");
        $eam_id = $this->input->post("eam_id");
        $action = $this->input->post("action");
        $CREATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');


        $data = array('PGL_ID' => $mitra_id,
            'P_DAT_AM_ID' => $eam_id,
            'ID_CC' => $cc_id,
            'CREATION_DATE' => $CREATED_DATE,
            'CREATE_BY' => $CREATED_BY
        );

        if ($action == "add") {
            $new_id = gen_id($pk, $table);
            $this->db->set($pk, $new_id);
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() > 0) {
                $data["success"] = true;
                $data["message"] = "Data berhasil ditambahakan";
            } else {
                $data["success"] = false;
                $data["message"] = "Gagal menambah data";
            }

        } elseif ($action == "edit") {
            $this->db->where($pk, $p_map_mit_cc);
            $this->db->update($table, $data);
            if ($this->db->affected_rows() > 0) {
                $data["success"] = true;
                $data["message"] = "Edit data berhasil";
            } else {
                $data["success"] = false;
                $data["message"] = "Gagal edit data";
            }
        } elseif ($oper == 'del') {
            $this->db->where($pk, $id_);
            $this->db->delete($table);
        } else {
            $data["success"] = false;
            $data["message"] = "Unknown Error";
        }
        echo json_encode($data);
    }

    public function crud_lokasimitra()
    {
        $this->db->_protect_identifiers = false;

        //$this->db->protect_identifiers('TEN_ND', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_LOKASI";
        $pk = "P_MP_LOKASI_ID";

        $LOKASI = $this->input->post('LOKASI');
        $P_MAP_MIT_CC_ID = $this->input->post('P_MAP_MIT_CC_ID');
        $CREATION_DATE = date('d/M/Y');
        $UPDATE_DATE = date('d/M/Y');
        $CREATE_BY = $this->session->userdata('d_user_name');
        $UPDATE_BY = $this->session->userdata('d_user_name');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_UNTIL = $this->input->post('VALID_UNTIL');


        switch ($oper) {
            case 'add':
                $data = array('P_MAP_MIT_CC_ID' => $P_MAP_MIT_CC_ID,
                    'LOKASI' => $LOKASI,
                    'CREATE_BY' => $CREATE_BY,
                    'CREATION_DATE' => $CREATION_DATE
                );

                $new_id = gen_id($pk, $table);
                $this->db->set($pk, $new_id);
                $this->db->set('VALID_FROM',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->insert($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Data berhasil ditambahakan";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal menambah data";
                }
                break;
            case 'edit':
                $data = array(
                    'LOKASI' => $LOKASI,
                    'UPDATE_BY' => $UPDATE_BY,
                    'UPDATE_DATE' => $UPDATE_DATE
                );
                $this->db->set('VALID_FROM',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->where($pk, $id_);
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Edit data berhasil";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal edit data";
                }
                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Data berhasil dihapus";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($data);

    }

    public function crud_mapping_pic()
    {
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_PIC";
        $pk = "P_MP_PIC_ID";

        $P_MP_PIC_ID = $this->input->post("p_mp_pic_id");
        $contact = $this->input->post('contact');
        $p_mp_lokasi_id = $this->input->post('p_mp_lokasi_id');
        $pic_id = $this->input->post('pic_id');

        $CREATE_DATE = date('d/M/Y');
        $UPDATE_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATE_BY = $this->session->userdata('d_user_name');


        switch ($oper) {
            case 'add':
                $data = array('P_MP_LOKASI_ID' => $p_mp_lokasi_id,
                    'P_CONTACT_TYPE_ID' => $contact,
                    'P_PIC_ID' => $pic_id,
                    'CREATED_BY' => $CREATED_BY,
                    'CREATE_DATE' => $CREATE_DATE,
                    'UPDATE_DATE' => $UPDATE_DATE,
                    'UPDATE_BY' => $UPDATE_BY
                );

                $new_id = gen_id($pk, $table);
                $this->db->set($pk, $new_id);
                $this->db->insert($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil ditambahakan";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menambah data";
                }
                break;
            case 'edit':
                $data = array('P_MP_LOKASI_ID' => $p_mp_lokasi_id,
                    'P_CONTACT_TYPE_ID' => $contact,
                    'P_PIC_ID' => $pic_id,
                    'UPDATE_DATE' => $UPDATE_DATE,
                    'UPDATE_BY' => $UPDATE_BY
                );
                $this->db->where($pk, $P_MP_PIC_ID);
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Edit data berhasil";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal edit data";
                }
                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil dihapus";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($datas);

    }

    public function crud_pks()
    {
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_PKS";
        $pk = "P_MP_PKS_ID";

        $P_MP_PKS_ID = $this->input->post('P_MP_PKS_ID');
        $NO_PKS = strtoupper($this->input->post("NO_PKS"));
        $P_MP_LOKASI_ID = $this->input->post('P_MP_LOKASI_ID');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_UNTIL = $this->input->post('VALID_UNTIL');

        $CREATED_DATE = date('d/M/Y');
        $UPDATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');


        switch ($oper) {
            case 'add':
                $data = array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID,
                    'NO_PKS' => $NO_PKS,
                  //  'VALID_FROM' => $VALID_FROM,
                  //  'VALID_UNTIL' => $VALID_UNTIL,
                    'CREATED_BY' => $CREATED_BY,
                    'CREATED_DATE' => $CREATED_DATE,
                    'UPDATED_DATE' => $UPDATED_DATE,
                    'UPDATED_BY' => $UPDATED_BY
                );
                $ck = $this->Mfee->checkDuplicate($table, 'NO_PKS', $NO_PKS);
                if ($ck > 0) {
                    $datas["success"] = false;
                    $datas["message"] = "No PKS sudah ada !";
                } else {
                    $new_id = gen_id($pk, $table);
                    $this->db->set($pk, $new_id);

                    $this->db->set('VALID_FROM',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                    $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);

                    $this->db->insert($table, $data);
                    if ($this->db->affected_rows() > 0) {
                        $datas["success"] = true;
                        $datas["message"] = "Data berhasil ditambahakan";
                    } else {
                        $datas["success"] = false;
                        $datas["message"] = "Gagal menambah data";
                    }
                }


                break;
            case 'edit':
                $data = array(
                    'NO_PKS' => $NO_PKS,
                   // 'VALID_FROM' => $VALID_FROM,
                   // 'VALID_UNTIL' => $VALID_UNTIL,
                    'UPDATED_DATE' => $UPDATED_DATE,
                    'UPDATED_BY' => $UPDATED_BY
                );
                $ck = $this->Mfee->checkDuplicate($table, 'NO_PKS', $NO_PKS);
                if ($ck > 0) {
                    $datas["success"] = false;
                    $datas["message"] = "No PKS sudah ada !";
                }else{
                    $this->db->set('VALID_FROM',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                    $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                    $this->db->where($pk, $P_MP_PKS_ID);
                    $this->db->update($table, $data);
                    if ($this->db->affected_rows() > 0) {
                        $datas["success"] = true;
                        $datas["message"] = "Edit data berhasil";
                    } else {
                        $datas["success"] = false;
                        $datas["message"] = "Gagal edit data";
                    }
                }

                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil dihapus";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($datas);

    }
	function crud_map_datin()
    {
        $this->db->_protect_identifiers = false;
        $this->db->protect_identifiers('PGID', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
		if(empty($id_)) {
			$id_ = "NULL";
		}
		
        $table = "P_MAP_DATIN_ACC";
        $PGL_ID = $this->input->post('PGID');
        $ACCOUNT_NUM = $this->input->post('ANNM');
        $VALID_FROM = $this->input->post('VF');
        $CREATED_BY = $this->session->userdata('d_user_name');
		$UPDATE_BY = $this->session->userdata('d_user_name');
        $VALID_UNTIL = $this->input->post('VU');
        $CREATION_DATE = $this->input->post('CD');
		$UPDATE_DATE = $this->input->post('UD');
		$P_MAP_DATIN_ACC_ID = $this->input->post('PMD');
		$timefr = strtotime($VALID_FROM);
		$timeutl = strtotime($VALID_UNTIL);
		$time_create = strtotime($CREATION_DATE);
		$time_update = strtotime($UPDATE_DATE);
		$VALID_FROM = date('d-M-Y',$timefr);
		$VALID_UNTIL = date('d-M-Y',$timeutl);
		$CREATION_DATE = date('d-M-Y',$time_create);
		$UPDATE_DATE = date('d-M-Y',$time_update);
		

        $data = array('PGL_ID' => $PGL_ID,
            'ACCOUNT_NUM' => $ACCOUNT_NUM,
            'VALID_FROM' => $VALID_FROM,
            'VALID_UNTIL' => $VALID_UNTIL,
            'CREATED_BY' => $CREATED_BY,
			'UPDATE_BY' => $UPDATE_BY,
			'CREATION_DATE' => $CREATION_DATE,
			'UPDATE_DATE' => $UPDATE_DATE,
			'P_MAP_DATIN_ACC_ID' => $P_MAP_DATIN_ACC_ID
        );

        switch ($oper) {
            case 'add':
				$data['P_MAP_DATIN_ACC_ID'] = gen_id('P_MAP_DATIN_ACC_ID','P_MAP_DATIN_ACC')+1;
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where('P_MAP_DATIN_ACC_ID', $id_);	
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('P_MAP_DATIN_ACC_ID', $id_);				
                $this->db->delete($table);
                break;
        }

    }
	public function getListPglAcc($id_pg,$id_acc) {
        $result = array();
        $sql = "SELECT B.* FROM APP_USER_C2BI A, CUST_PGL B WHERE A.PGL_ID=B.PGL_ID AND A.USER_ID=".$user_id;
        $sql .= " ORDER BY B.PGL_NAME";
		$sql = "select a.pgl_id PG, a.ACCOUNT_NUM AN from P_MAP_DATIN_ACC a, cust_pgl b, MV_LIS_ACCOUNT_NP c where b.". $id_pg . " = a.pgl_id AND c.". $id_acc ." = a.ACCOUNT_NUM";
        $q = $this->db->query($sql);
        if($q->num_rows() > 0) {
            $result = $q->result();
        }
        return $result;

    }

}