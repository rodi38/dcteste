<script>

    const DEBOUNCE_DELAY = 500;

    const totalValueInput = document.getElementById('totalValue');
    const installmentsContainer = document.getElementById('installmentsContainer');

    let installments = [];
    let productCount = 0;
    let debounceTimeout;

    document.addEventListener('DOMContentLoaded', () => {
        showDiv('sale-info');
        initializeEventListeners();
        initializeExistingInstallments();
    });

    function initializeExistingInstallments() {
        const existingInstallments = document.querySelectorAll('.installment-row input[name^="installments["][name$="[value]"]');
        installments = Array.from(existingInstallments).map(input => parseFloat(input.value) || 0);

        if (installments.length > 0) {
            addInstallmentListeners();
            calculateTotal();
        }
    }

    function initializeEventListeners() {
        const productSelects = document.querySelectorAll('select[name^="items["]');
        const amountInputs = document.querySelectorAll('input[name^="items["]');

        productSelects.forEach(select => select.addEventListener('change', calculateTotal));
        amountInputs.forEach(input => input.addEventListener('input', calculateTotal));

        document.getElementById('addInstallments').addEventListener('click', handleAddInstallments);
    }

    function showDiv(divId) {
        const divs = ['sale-info', 'sale-items', 'payment'];
        divs.forEach(div => document.getElementById(div).classList.add('d-none'));
        document.getElementById(divId).classList.remove('d-none');
    }

    function addProduct() {
        productCount++;
        const productHTML = createProductHTML(productCount);
        document.getElementById('productsContainer').insertAdjacentHTML('beforeend', productHTML);
        addProductEventListeners(productCount);
    }

    function createProductHTML(index) {
        return `
        <div>
            <div class="form-group">
                <label for="items[${index}][product_id]" class="fs-1">Produto ${index}:</label>
                <select name="items[${index}][product_id]" class="form-control product-select">
                    <option selected></option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="items[${index}][amount]">Quantidade:</label>
                <input type="number" name="items[${index}][amount]" class="form-control amount-input" min="1" required>
            </div>
        </div>`;
    }

    function addProductEventListeners(index) {
        const newProductSelect = document.querySelector(`select[name="items[${index}][product_id]"]`);
        const newAmountInput = document.querySelector(`input[name="items[${index}][amount]"]`);

        newProductSelect.addEventListener('change', calculateTotal);
        newAmountInput.addEventListener('input', calculateTotal);
    }

    function calculateTotal() {
        const productSelects = document.querySelectorAll('select[name^="items["]');
        const amountInputs = document.querySelectorAll('input[name^="items["]');

        const total = Array.from(productSelects).reduce((sum, select, index) => {
            const productPrice = select.options[select.selectedIndex].dataset.price || 0;
            const quantity = amountInputs[index].value || 0;
            return sum + (productPrice * quantity);
        }, 0);

        totalValueInput.value = total.toFixed(2);
    }

    function handleAddInstallments() {
        const numberOfInstallments = document.getElementById('number_installments').value;
        const totalAmount = parseFloat(totalValueInput.value) || 0;
        createInstallments(totalAmount, numberOfInstallments);
    }

    function createInstallments(totalAmount, numberOfInstallments) {
        const installmentAmount = Math.floor((totalAmount / numberOfInstallments) * 100) / 100;
        installments = Array(Number(numberOfInstallments)).fill(installmentAmount);
        renderInstallments();
    }

    function updateInstallments(totalAmount, numberOfInstallments, changedInstallmentIndex, newAmount) {
        installments[changedInstallmentIndex] = newAmount;

        const sumUpToCurrentInstallment = installments.slice(0, changedInstallmentIndex + 1).reduce((sum, amount) => sum + amount, 0);
        const remainingAmount = totalAmount - sumUpToCurrentInstallment;
        const remainingInstallments = numberOfInstallments - (changedInstallmentIndex + 1);

        if (remainingInstallments > 0) {
            const newInstallmentAmount = Math.floor((remainingAmount / remainingInstallments) * 100) / 100;
            installments.fill(newInstallmentAmount, changedInstallmentIndex + 1);

            const roundingError = remainingAmount - (newInstallmentAmount * remainingInstallments);
            installments[installments.length - 1] += roundingError;
        }

        renderInstallments();
    }

    function renderInstallments() {
        installmentsContainer.innerHTML = installments.map((amount, index) => createInstallmentHTML(amount, index)).join('');
        addInstallmentListeners();
    }

    function createInstallmentHTML(amount, index) {
        const isLastInstallment = index === installments.length - 1;
        return `
        <div class="installment-row mt-2">
            <label for="installments[${index}][value]">Valor da parcela:</label>
            <input type="number" name="installments[${index}][value]" step="0.01" value="${amount.toFixed(2)}" required class="form-control" ${isLastInstallment ? 'readonly' : ''}>
            <label for="installments[${index}][expiration_date]">Data de expiração:</label>
            <input type="date" name="installments[${index}][expiration_date]" value="${new Date().toISOString().split('T')[0]}" required class="form-control">
            <input type="hidden" name="installments[${index}][paid]" value="0">
        </div>`;
    }


    function addInstallmentListeners() {
        const installmentInputs = document.querySelectorAll('input[name^="installments["][name$="[value]"]');
        installmentInputs.forEach((input, index) => {
            if (index !== installments.length - 1) {
                input.addEventListener('input', debounce(() => {
                    const newValue = parseFloat(input.value) || 0;
                    const totalAmount = parseFloat(totalValueInput.value) || 0;
                    if (newValue <= totalAmount) {
                        updateInstallments(totalAmount, installments.length, index, newValue);
                    }
                }, DEBOUNCE_DELAY));
            }
        });
    }

    function debounce(func, delay) {
        return function () {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => func.apply(this, arguments), delay);
        };
    }



</script>