<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold mb-0">
                {{ __('Lista de Produtos') }}
            </h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('Adicionar Novo Produto') }}</a>
        </div>
    </x-slot>

    <div class="shadow-sm">
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">{{ __('Nome') }}</th>
                        <th scope="col">{{ __('Descrição') }}</th>
                        <th scope="col">{{ __('Preço') }}</th>
                        <th scope="col">{{ __('Estoque') }}</th>
                        <th scope="col" class="text-end">{{ __('Ações') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="text-truncate" style="max-width: 200px;" title="{{ $product->description }}">
                                {{ $product->description }}
                            </td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock_quantity }} </td>
                            <td class="text-end">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">
                                    {{ __('Ver') }}
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                    {{ __('Editar') }}
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('Excluir') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('Nenhum produto cadastrado.') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>