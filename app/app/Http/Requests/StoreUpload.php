<?php

namespace App\Http\Requests;

use App\Helpers\FileHelper;
use App\Helpers\PhpConfigHelper;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpload extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'upload_file' => 'File',
		];
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		$uploadMaxFilesize= PhpConfigHelper::getUploadMaxFilesize();
		$maxSize = FileHelper::convertToBytes($uploadMaxFilesize);
		$userUploadsTotalSize = $this->user()->uploadsTotalSize;
		$userSize = FileHelper::convertToBytes($userUploadsTotalSize);
		$availableSize = $maxSize - $userSize;
		return [
			'upload_file' => [
				'required',
				'file',
				'max:' . FileHelper::convertToKilobytes($availableSize),
			],
		];
	}
}
