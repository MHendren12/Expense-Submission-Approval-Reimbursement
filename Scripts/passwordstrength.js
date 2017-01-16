function scorePassword(pass) {
    var score = 0;
    if (!pass)
        return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
}

function checkPassStrength(pass) {
    var score = scorePassword(pass);
    if (score > 80)
    {
        document.getElementById("strength").style.color = "#00ff00";
        return "Password Strength: Strong";
    }
    if (score > 60)
    {
        document.getElementById("strength").style.color = "#cccc00";
        return "Password Strength: Good";
    }
    if (score > 30)
    {
        document.getElementById("strength").style.color = "#efab00";
        return "Password Strength: Average";
    }
    if (score >= 0)
    {
        document.getElementById("strength").style.color = "#ff0000";
        return "Password Strength: Weak";
    }
    return "";
}

$(document).ready(function() {
    $("#password").on("keypress keyup keydown", function() {
        var pass = $(this).val();
        $("#strength").text(checkPassStrength(pass));
        $("#strength_score").text(scorePassword(pass));
    });
});
