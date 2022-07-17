<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Jurusan extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Jurusan_model', 'jsn');
	}
	public function index_get() // memanggil 1 atau semua data
	{
		$id = $this->get('id');
		if ($id == null) {
			$jurusan = $this->jsn->get(); // user menampilkan semua data
		} else {
			$jurusan = $this->jsn->get($id); // user memanggil data by id
		}

		if ($jurusan) {
			$this->response([
				'status' => true,
				'data' => $jurusan
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => "Id Tidak Ditemukan"
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function index_delete() //untuk menghapus data
	{
		$id = $this->delete('id');
		if ($id == null) {
			$this->response([
				'status' => false,
				'message' => 'Masukkan ID'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->jsn->delete($id) > 0) {
				$this->response([
					'status' => true,
					'id' => $id,
					'message' => 'Data berhasil dihapus'
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Id Tidak Ditemukan'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}
	public function index_post() //untuk menambah data
	{
		$data = [
			'nama' => $this->post('nama'),
			'singkatan' => $this->post('singkatan'),
			'kajur' => $this->post('kajur'),
		];
		if ($this->jsn->insert($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'Data berhasil ditambah'
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Gagal Menambahkan data'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'nama' => $this->put('nama'),
			'singkatan' => $this->put('singkatan'),
			'kajur' => $this->put('kajur'),
		];
		if ($this->jsn->update($data, $id) > 0) {
			$this->response([
				'status' => true,
				'message' => 'Data berhasil diubah'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Gagal Mengubah data'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
