<div class="progress-container" style="margin-bottom: 20px;">
    <ul class="progress-steps">
        <li class="{{ $step >= 1 ? 'active' : '' }}">1. Cart</li>
        <li class="{{ $step >= 2 ? 'active' : '' }}">2. Confirmation</li>
        <li class="{{ $step >= 3 ? 'active' : '' }}">3. Status</li>
    </ul>
</div>

<style>
    .progress-container {
        text-align: center;
        width: 100%;
        margin: 0 auto;
    }

    .progress-steps {
        display: flex;
        justify-content: space-around;
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }

    .progress-steps::before {
        content: "";
        position: absolute;
        top: 10px;
        left: 10%;
        right: 10%;
        height: 3px;
        background-color: #e0e0e0;
        z-index: 0;
    }

    .progress-steps li {
        position: relative;
        z-index: 1;
        width: 33%;
        font-size: 20px;
        font-weight: bold;
        color: #bbb;
        text-align: center;
    }

    .progress-steps li.active {
        color: #28a745;
    }

    .progress-steps li::before {
        content: "";
        position: absolute;
        top: -7px;
        left: 50%;
        transform: translateX(-50%);
        width: 15px;
        height: 15px;
        background: #e0e0e0;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .progress-steps li.active::before {
        background: #28a745;
    }
</style>