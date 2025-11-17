<h2>Chọn snack</h2>
<form id="snackForm">
    @csrf
    <div id="snackContainer">
        @foreach($snacks as $snack)
            <div>
                <span>{{ $snack->ten_mon }} ({{ number_format($snack->gia) }} VND)</span>
                <input type="number" class="snackQty" data-price="{{ $snack->gia }}" value="0" min="0">
                <input type="hidden" class="snackId" value="{{ $snack->id }}">
            </div>
        @endforeach
    </div>

    <p>Tổng tiền snack: <span id="snackTotal">0</span> VND</p>
    <button type="button" id="checkoutBtn">Thanh toán</button>
</form>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const snackContainer = document.getElementById("snackContainer");
    const snackTotalEl = document.getElementById("snackTotal");

    function calculateSnackTotal() {
        let total = 0;
        const inputs = snackContainer.querySelectorAll(".snackQty");
        inputs.forEach(input => {
            const price = parseFloat(input.dataset.price);
            const qty = parseInt(input.value) || 0;
            total += price * qty;
        });
        snackTotalEl.textContent = total;
    }

    snackContainer.addEventListener("input", calculateSnackTotal);
    calculateSnackTotal();

    document.getElementById("checkoutBtn").addEventListener("click", async function() {
        const seats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');
        if(seats.length === 0) {
            alert("Không tìm thấy ghế đã chọn");
            return;
        }

        const snacks = Array.from(snackContainer.querySelectorAll('.snackQty'))
            .filter(input => parseInt(input.value) > 0)
            .map(input => ({
                id: input.previousElementSibling.value,
                quantity: parseInt(input.value)
            }));

        const data = { seats, snacks };

        try {
            const response = await fetch(`/booking/{{ $showtime->id }}/finalize`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if(response.ok) {
                alert("✅ Đặt vé + snack thành công!");
                window.location.href = `/checkout/${result.booking_id}`;
            } else {
                alert("❌ Lỗi: " + result.message);
            }
        } catch(err) {
            alert("❌ Lỗi server: " + err.message);
        }
    });
});
</script>
