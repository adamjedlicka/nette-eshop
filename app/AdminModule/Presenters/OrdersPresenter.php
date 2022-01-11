<?php

namespace App\AdminModule\Presenters;

use App\Model\Facades\OrdersFacade;
use App\Model\Repositories\OrderRepository;
use App\StorefrontModule\Components\PaginationControl\PaginationControl;
use App\StorefrontModule\Components\PaginationControl\PaginationControlFactory;

class OrdersPresenter extends BasePresenter
{
    private OrderRepository $orderRepository;
    private OrdersFacade $ordersFacade;
    private PaginationControlFactory $paginationControlFactory;

    public function __construct(
        OrderRepository $orderRepository,
        OrdersFacade $ordersFacade,
        PaginationControlFactory $paginationControlFactory
    )
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->ordersFacade = $ordersFacade;
        $this->paginationControlFactory = $paginationControlFactory;
    }

    public function actionDefault()
    {
        $paginationControl = $this->getComponent('pagination');

        $paginationControl->disableAjax();
        $paginationControl->getPaginator()->setPage($paginationControl->getCurrentPage());
        $paginationControl->getPaginator()->setItemCount($this->orderRepository->findCountBy());
        $paginationControl->getPaginator()->setItemsPerPage(10);

        $this->template->orders = $this->orderRepository->findAllBy(
            ['order' => 'created_at DESC'],
            $paginationControl->getPaginator()->getOffset(),
            $paginationControl->getPaginator()->getItemsPerPage()
        );
    }

    public function handleMarkPaid(int $id): void
    {
        $this->ordersFacade->markOrderPaid($id);
        $this->redirect('default');
    }

    public function handleMarkShipped(int $id): void
    {
        $this->ordersFacade->markOrderSent($id);
        $this->redirect('default');
    }

    protected function createComponentPagination(): PaginationControl
    {
        return $this->paginationControlFactory->create();
    }

}
