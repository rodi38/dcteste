<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a href="{{route('sales.index')}}" class="page-link">Voltar</a>
        </li>
        <li class="page-item"><a class="page-link" href="#sale-info" onclick="showDiv('sale-info')">Informações</a></li>
        <li class="page-item"><a class="page-link" href="#sale-items" onclick="showDiv('sale-items')">Produto</a>
        </li>
        <li class="page-item"><a class="page-link" href="#payment" onclick="showDiv('payment')">Pagamento</a></li>

    </ul>
</nav>