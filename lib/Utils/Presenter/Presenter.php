<?php
namespace Utils\Presenter;

class Presenter
{
    /**
     * @param object $data
     * @return array
     */
    protected function extractData($data)
    {
        if (empty($data)) {
            return [];
        } else {
            return [
                'object' => var_export($data, true)
            ];
        }
    }

    /**
     * @param object $data
     * @return string
     */
    public function present($data)
    {
        $view = $this->extractData($data);
        return json_encode($view);
    }

    /**
     * @param $data
     * @return array
     */
    public function presentAsArray($data)
    {
        return $this->extractData($data);
    }
}