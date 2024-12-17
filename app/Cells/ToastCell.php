<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ToastCell extends Cell
{
    public $type;
    public $message;

    protected string $view = "components/toast";

    public function mount()
    {
        $toastError = session()->getFlashdata("toast_error");
        $toastWarning = session()->getFlashdata("toast_warning");
        $toastSuccess = session()->getFlashdata("toast_success");
        $toastInfo = session()->getFlashdata("toast_info");

        if (!empty($toastError)) {
            $this->type    = 'error';
            $this->message = $toastError;
        } else  if (!empty($toastWarning)) {
            $this->type    = 'warning';
            $this->message = $toastWarning;
        } else  if (!empty($toastSuccess)) {
            $this->type    = 'success';
            $this->message = $toastSuccess;
        } else  if (!empty($toastInfo)) {
            $this->type    = 'info';
            $this->message = $toastInfo;
        }
    }
}
