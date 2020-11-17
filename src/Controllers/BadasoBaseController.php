<?php

namespace Uasoft\Badaso\Controllers;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Helpers\ApiResponse;

class BadasoBaseController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $slug = $this->getSlug($request);
            $data_type = $this->getDataType($slug);
            $data = $this->getDataList($slug, $request->all());

            return ApiResponse::entity($data_type, $data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $slug = $this->getSlug($request);
            $data_type = $this->getDataType($slug);
            $data = $this->getDataDetail($slug, $request->id);

            return ApiResponse::entity($data_type, $data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required',
                'data' => [
                    'required',
                ],
            ]);
            $slug = $this->getSlug($request);
            $data_type = $this->getDataType($slug);
            $data = $this->createDataFromRaw($request->input('data') ?? [], $data_type);
            $this->validateData($data, $data_type);
            $updated_data = $this->updateData($data, $data_type);

            return ApiResponse::entity($data_type, $updated_data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required',
                'data' => [
                    'required',
                ],
            ]);
            $slug = $this->getSlug($request);
            $data_type = $this->getDataType($slug);
            $data = $this->createDataFromRaw($request->input('data') ?? [], $data_type);
            $this->validateData($data, $data_type);
            $stored_data = $this->insertData($data, $data_type);

            return ApiResponse::entity($data_type, $stored_data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required',
                'data' => [
                    'required',
                ],
            ]);
            $slug = $this->getSlug($request);
            $data_type = $this->getDataType($slug);
            $data = $this->createDataFromRaw($request->input('data') ?? [], $data_type);
            $this->deleteData($data, $data_type);

            return ApiResponse::entity($data_type);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
