<script>
    const productSelect = document.querySelectorAll('select[name^="items["]');
    const amountInputs = document.querySelectorAll('input[name^="items["]');
    const totalValueInput = document.getElementById('totalValue');

    let installments = [];
    let debounceTimeout;

    let productCount = 0;

    function calculateTotal() {
        let total = 0;

        const productSelects = document.querySelectorAll('select[name^="items["]');
        const amountInputs = document.querySelectorAll('input[name^="items["]');

        productSelects.forEach((select, index) => {
            const selectedOption = select.options[select.selectedIndex];
            const productPrice = selectedOption.dataset.price || 0;
            const quantity = amountInputs[index].value || 0;
            total += productPrice * quantity;
        });

        totalValueInput.value = total.toFixed(2);
    }

    calculateTotal();

    productSelect.forEach(select => {
        select.addEventListener('change', calculateTotal);
    });

    amountInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });





    function showDiv(divId) {
        document.getElementById('sale-info').classList.add('d-none');
        document.getElementById('sale-items').classList.add('d-none');
        document.getElementById('payment').classList.add('d-none');
        document.getElementById(divId).classList.remove('d-none');
    }

    document.addEventListener('DOMContentLoaded', function () {
        showDiv('sale-info');
    });



    function addProduct() {
        productCount++;


        const productDiv = `
                                        <div>
                                            <div class="form-group">
                                                <label for="items[${productCount}][product_id]" class="fs-1">Produto ${productCount}:</label>
                                                <select name="items[${productCount}][product_id]" class="form-control product-select">
                                                    <option selected></option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="items[${productCount}][amount]">Quantidade:</label>
                                                <input type="number" name="items[${productCount}][amount]" class="form-control amount-input" min="1" required>
                                            </div>
                                        </div>`;

        document.getElementById('productsContainer').insertAdjacentHTML('beforeend', productDiv);

        const newProductSelect = document.querySelector(`select[name="items[${productCount}][product_id]"]`);
        const newAmountInput = document.querySelector(`input[name="items[${productCount}][amount]"]`);

        newProductSelect.addEventListener('change', calculateTotal);
        newAmountInput.addEventListener('input', calculateTotal);
    }



    document.getElementById('addInstallments').addEventListener('click', function () {
        const numberOfInstallments = document.getElementById('number_installments').value;
        const totalAmount = parseFloat(document.getElementById('totalValue').value) || 0;

        createInstallments(totalAmount, numberOfInstallments);
    });

    function createInstallments(totalAmount, numberOfInstallments) {
        installments = [];

        const installmentAmount = Math.floor((totalAmount / numberOfInstallments) * 100) / 100;



        for (let i = 0; i < numberOfInstallments; i++) {
            installments.push(installmentAmount);
        }

        renderInstallments();

    }




    function updateInstallments(totalAmount, numberOfInstallments, changedInstallmentIndex, newAmount) {
        installments[changedInstallmentIndex] = newAmount;

        let sumUpToCurrentInstallment = 0;
        let somaParcelasRestantes = 0;

        installments.forEach((amount, index) => {
            if (index <= changedInstallmentIndex) {
                sumUpToCurrentInstallment += installments[index];
            }
            if (index > changedInstallmentIndex) {
                const newInstallmentAmount = Math.floor(((totalAmount - sumUpToCurrentInstallment) / (numberOfInstallments - (changedInstallmentIndex + 1))) * 100) / 100;
                installments[index] = newInstallmentAmount;
                somaParcelasRestantes += newInstallmentAmount;
            }



        });

        const resto = totalAmount - (sumUpToCurrentInstallment + somaParcelasRestantes);
        installments[installments.length - 1] += resto;



        renderInstallments();
    }


    function renderInstallments() {
        const installmentsContainer = document.getElementById('installmentsContainer');
        installmentsContainer.innerHTML = '';

        installments.forEach((amount, index) => {
            const installmentRow = document.createElement('div');
            installmentRow.className = 'installment-row mt-2';

            installmentRow.innerHTML = `
            <label for="installments[${index}][value]">Valor da parcela:</label>
            <input type="number" name="installments[${index}][value]" step="0.01" value="${amount.toFixed(2)}" required class="form-control" ${index === installments.length - 1 ? 'readonly' : ''}>
            <label for="installments[${index}][expiration_date]">Data de expiração:</label>
            <input type="date" name="installments[${index}][expiration_date]" value="${new Date().toISOString().split('T')[0]}" required class="form-control">
            <input type="hidden" name="installments[${index}][paid]" value="0">
        `;

            installmentsContainer.appendChild(installmentRow);
        });

        addListeners();
    }

    function addListeners() {
        const installmentInputs = document.querySelectorAll('input[name^="installments["][name$="[value]"]');


        installmentInputs.forEach((input, index) => {
            if (index !== installments.length - 1) {
                input.addEventListener('input', function () {
                    const newValue = parseFloat(input.value) || 0;
                    const numberOfInstallments = installments.length;
                    const totalAmount = parseFloat(document.getElementById('totalValue').value) || 0;

                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => {
                        if (newValue <= totalAmount) {
                            updateInstallments(totalAmount, numberOfInstallments, index, newValue);
                        }
                    }, 500);
                });
            }
        });
    }



    function createArr(arr) {
        installments = arr.map(({ value }) => {
            return value;
        })


    }

</script>
