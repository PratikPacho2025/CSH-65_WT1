<?php
$units = '';
$total = null;
$error = '';
$breakdown = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unitsInput = trim($_POST['units'] ?? '');
    $units = $unitsInput;

    if ($unitsInput === '') {
        $error = 'Please enter consumed units.';
    } elseif (!is_numeric($unitsInput)) {
        $error = 'Units must be a numeric value.';
    } elseif ((float)$unitsInput < 0) {
        $error = 'Units cannot be negative.';
    } else {
        $unitsValue = (float)$unitsInput;
        $remaining = $unitsValue;
        $total = 0.0;

        $slabs = [
            ['limit' => 50, 'rate' => 3.50, 'label' => 'First 50 units'],
            ['limit' => 100, 'rate' => 4.00, 'label' => 'Next 100 units'],
            ['limit' => 100, 'rate' => 5.20, 'label' => 'Next 100 units'],
            ['limit' => INF, 'rate' => 6.50, 'label' => 'Above 250 units']
        ];

        foreach ($slabs as $slab) {
            if ($remaining <= 0) {
                break;
            }

            $consumedInSlab = min($remaining, $slab['limit']);
            $charge = $consumedInSlab * $slab['rate'];
            $total += $charge;

            $breakdown[] = [
                'label' => $slab['label'],
                'units' => $consumedInSlab,
                'rate' => $slab['rate'],
                'charge' => $charge
            ];

            $remaining -= $consumedInSlab;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="page-shell">
        <section class="bill-card container">
            <div class="top-badge">PHP PROJECT</div>

            <div class="hero-grid">
                <div class="intro-panel">
                    <h1 class="hero-title">Electricity Bill<br>Calculator</h1>
                    <p class="hero-copy">Calculate your electricity bill using slab-based pricing in PHP.</p>

                    <div class="tariff-box">
                        <h3>Tariff Slabs</h3>
                        <ul>
                            <li>First 50 units - Rs. 3.50 / unit</li>
                            <li>Next 100 units - Rs. 4.00 / unit</li>
                            <li>Next 100 units - Rs. 5.20 / unit</li>
                            <li>Above 250 units - Rs. 6.50 / unit</li>
                        </ul>
                    </div>
                </div>

                <div class="calculator-panel">
                    <h2>Calculate Bill</h2>
                    <p>Enter the consumed units and calculate the total bill.</p>

                    <form id="billForm" method="post" novalidate>
                        <label for="units" class="field-label">Units Consumed</label>
                        <input
                            type="number"
                            class="form-control"
                            id="units"
                            name="units"
                            value="<?php echo htmlspecialchars($units, ENT_QUOTES, 'UTF-8'); ?>"
                            min="0"
                            step="0.01"
                            placeholder="50"
                            required
                        >
                        <small id="clientError" class="text-danger d-none"></small>
                        <button type="submit" class="submit-btn">Calculate Bill</button>
                    </form>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger mt-3 mb-0" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>

                    <?php if ($total !== null && $error === ''): ?>
                        <div class="result-box mt-4 p-3 rounded-3">
                            <h2 class="h5 mb-3">Bill Summary</h2>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-3">
                                    <thead>
                                        <tr>
                                            <th>Slab</th>
                                            <th class="text-end">Units</th>
                                            <th class="text-end">Rate (Rs.)</th>
                                            <th class="text-end">Charge (Rs.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($breakdown as $row): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-end"><?php echo number_format($row['units'], 2); ?></td>
                                                <td class="text-end"><?php echo number_format($row['rate'], 2); ?></td>
                                                <td class="text-end"><?php echo number_format($row['charge'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center total-row p-3 rounded-3">
                                <span class="fw-semibold">Total Payable Amount</span>
                                <span class="fs-4 fw-bold">Rs. <?php echo number_format($total, 2); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-strip">
                <div class="info-item">
                    <span class="info-icon">👤</span>
                    <div>
                        <span class="info-label">Name:</span>
                        <strong>Pratik Pachorkar</strong>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-icon">📝</span>
                    <div>
                        <span class="info-label">Assignment:</span>
                        <strong>PHP Electricity Bill Calculator</strong>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-icon">🪪</span>
                    <div>
                        <span class="info-label">Roll No:</span>
                        <strong>65</strong>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
