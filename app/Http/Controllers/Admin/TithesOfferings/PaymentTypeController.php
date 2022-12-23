<?php

namespace App\Http\Controllers\Admin\TithesOfferings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentTypeRequest;
use App\Models\TithesOfferings\TitheOfferingPaymentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentTypeController extends Controller
{
    public function index(): View
    {
        $paymentTypes = TitheOfferingPaymentType::orderBy('id', 'asc')->paginate(10);

        return view('content.admin.tithes_offerings.payment_types', compact('paymentTypes'));
    }

    public function store(StorePaymentTypeRequest $request): RedirectResponse
    {
        TitheOfferingPaymentType::create($request->validated());

        return back()->withSuccess('Você criou o tipo de pagamento "' . $request->type_name . '" com sucesso!');
    }

    public function update(TitheOfferingPaymentType $type, StorePaymentTypeRequest $request): RedirectResponse
    {
        $type->update($request->validated());

        return back()->withSuccess('Você editou o tipo de pagamento "' . $request->type_name . '" com sucesso!');
    }

    public function delete(TitheOfferingPaymentType $type): RedirectResponse
    {
        $type->delete();

        return back()->withSuccess('Você deletou o tipo de pagamento "' . $type->type_name . '"!');
    }
}
