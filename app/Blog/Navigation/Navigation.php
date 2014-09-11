<?php


namespace Blog\Navigation;

use Joseki\LeanMapper\Query;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

class Navigation extends Control
{

    /** @var SectionRepository */
    private $sectionRepository;

    private $currentSection;



    function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }



    public function render()
    {

        /** @var Template $template */
        $template = $this->createTemplate();
        $template->current = $section = $this->getCurrent();
        $template->items = $this->getChildren($section);
        $template->setFile(__DIR__ . '/Navigation.template.latte');
        $template->render();
    }



    private function resolveLink()
    {
        $action = $this->getPresenter()->getAction(true);
        return $action;
    }



    private function getChildren(Section $section)
    {
        return $this->sectionRepository->getChildren($section->id);
    }



    public function renderBreadScrums()
    {

        /** @var Template $template */
        $template = $this->createTemplate();
        $template->current = $section = $this->getCurrent();
        $template->items = $this->getParents($section);
        $template->setFile(__DIR__ . '/Navigation.breadScrums.latte');
        $template->render();
    }



    private function getParents(Section $section)
    {
        return $this->sectionRepository->getParents($section->id, false);
    }



    private function getCurrent()
    {
        if (!$this->currentSection) {
            $query = new Query();
            $query->where('@link = %s', $this->resolveLink());
            $this->currentSection = $this->sectionRepository->findOneBy($query);
        }
        return $this->currentSection;
    }

}
