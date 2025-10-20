<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0">
            Detalhes do Produto: {{ $product->name }}
        </h2>
    </x-slot>

        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $product->id }}</dd>

                    <dt class="col-sm-3">Nome</dt>
                    <dd class="col-sm-9">{{ $product->name }}</dd>

                    <dt class="col-sm-3">Descrição</dt>
                    <dd class="col-sm-9">{{ $product->description ?? 'Nenhuma descrição informada.' }}</dd>

                    <dt class="col-sm-3">Preço</dt>
                    <dd class="col-sm-9">R$ {{ number_format($product->price, 2, ',', '.') }}</dd>

                    <dt class="col-sm-3">Quantidade em Estoque</dt>
                    <dd class="col-sm-9">{{ $product->stock_quantity }} unidades</dd>

                    <dt class="col-sm-3">Criado em</dt>
                    <dd class="col-sm-9">{{ $product->created_at->format('d/m/Y H:i:s') }}</dd>

                    <dt class="col-sm-3">Atualizado em</dt>
                    <dd class="col-sm-9">{{ $product->updated_at->format('d/m/Y H:i:s') }}</dd>
                </dl>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar para a Lista</a>
                </div>
            </div>
        </div>
</x-app-layout>