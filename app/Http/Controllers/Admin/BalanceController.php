<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\User;
use App\Http\Requests\MoneyValidationFormRequest;

class BalanceController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        // create amount 0 para users que não tem nenhum registro em balance
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->value);

        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function withdraw()
    {
        return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->value);

        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function transfer()
    {
        return view('admin.balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        $sender = $user->getSender($request->sender);
        if (!$sender)
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado!');

        if ($sender->id === auth()->user()->id)
            return redirect()
                ->back()
                ->with('error', 'Não pode transferir para você mesmo!');

        $balance = auth()->user()->balance;

        return view('admin.balance.transfer-confirm', compact('sender', 'balance'));
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
        $sender = $user->find($request->sender_id);
        if (!$sender)
            return redirect()
                ->route('balance.transfer')
                ->with('error', 'Recebedor não Encontrado!');

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->value, $sender);

        if ($response['success'])
            return redirect()
                ->route('admin.balance')
                ->with('success', $response['message']);

        return redirect()
            ->route('balance.transfer')
            ->with('error', $response['message']);
    }

    public function historic()
    {
        // historic do user que esta logado
        $historics = auth()->user()->historics()->get();

        return view('admin.balance.historics', compact('historics'));
    }
}
