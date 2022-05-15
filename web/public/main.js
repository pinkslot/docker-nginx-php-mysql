(() => {
    const fillState = ({bonusesAmount, moneyAmount, moneyBalance}) => {
        document.getElementById('money-count').innerHTML = moneyAmount;
        document.getElementById('bonuses-count').innerHTML = bonusesAmount;
        document.getElementById('money-balance').innerHTML = moneyBalance;
    }

    const button = document.getElementById('take-prize');
    button.addEventListener('click', () => {
        fetch('take-prize', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
        }).then(response => response.json().then(data => fillState(data)))
    });

    fetch('state', {
        method: 'GET',
        headers: {
            'Content-type': 'application/json',
        },
    }).then(response => response.json().then(data => fillState(data)))
})();
