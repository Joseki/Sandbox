<?php

namespace MyApplication\App;

class SitemapPresenter extends Presenter
{

    public function renderDefault()
    {
        $this->template->sections = $this->sectionRepository->findAll();
    }
}
