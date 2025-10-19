<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0">
            {{ __('Adicionar Novo Produto') }}
        </h2>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{__('Nome do Produto')}}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name') }}" required maxlength="255">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{__('Descrição (Opcional)')}}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                              name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">{{__('Preço')}}</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                           name="price" value="{{ old('price') }}" required step="0.01" min="0.01">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">{{__('Quantidade em Estoque')}}</label>
                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required
                           min="0">
                    @error('stock_quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{__('Cancelar')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Salvar Produto')}}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>