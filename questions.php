<?php
$prof_id = isset($_GET['prof_id']) ? intval($_GET['prof_id']) : 0;
if ($prof_id === 0) {
    die("Invalid professor ID.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Rating - Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #cccccc;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
            height: 100vh;
            background-image: url('https://img.freepik.com/premium-photo/abstract-yellow-black-gradient-plain-studio-background_570543-10544.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        h2 {
            font-size: 5vw;
            text-align: center;
            margin-bottom: 30px;
            width: 90%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .question {
            width: 100%;
            max-width: 1200px;
            margin-bottom: 50px;
            padding: 30px;
        }
        .question label {
            display: block;
            font-size: min(3vw, 24px);
            margin-bottom: 15px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            width: 100%;
        }
        .rating {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .rating label {
            font-size: 1vw;
        }
        .rating input {
            margin-right: 10px;
        }
        button {
            width: 100%;
            max-width: 600px;
            padding: 15px;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 2.5vw;
            cursor: pointer;
            font-weight: bold;
            margin-top: 30px;
        }
        button:hover {
            background: #FFC000;
        }
        nav {
            background-color: rgba(0, 0, 0, 0.8);
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        nav .logo {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">ProfRate</div>
    </nav>
    <h2>Professor Rating Questionnaire</h2>
    <form id="questionnaireForm" method="POST" action="submit_ratings.php">
        <input type="hidden" name="prof_id" value="<?php echo $prof_id; ?>">
        <div class="question">
            <label for="teachingStyle">1. How would you rate the professor’s teaching style?</label>
            <div class="rating">
                <label><input type="radio" name="teachingStyle" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="teachingStyle" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="teachingStyle" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="teachingStyle" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="teachingStyle" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="answeringQuestions">2. How well does the professor answer student questions?</label>
            <div class="rating">
                <label><input type="radio" name="answeringQuestions" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="answeringQuestions" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="answeringQuestions" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="answeringQuestions" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="answeringQuestions" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="workload">3. How reasonable was the workload?</label>
            <div class="rating">
                <label><input type="radio" name="workload" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="workload" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="workload" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="workload" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="workload" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="examBasedOn">4. Were exam questions based on lectures, textbooks, or both?</label>
            <div class="rating">
                <label><input type="radio" name="examBasedOn" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="examBasedOn" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="examBasedOn" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="examBasedOn" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="examBasedOn" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="approachability">5. How approachable is the professor for questions outside of class? (Very approachable, Somewhat approachable, Not approachable)</label>
            <div class="rating">
                <label><input type="radio" name="approachability" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="approachability" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="approachability" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="examBasedOn" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="examBasedOn" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="respect">6. Does the professor treat students with respect?</label>
            <div class="rating">
                <label><input type="radio" name="respect" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="respect" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="respect" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="respect" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="respect" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="assignments">7. How useful were the assignments in understanding the material?</label>
            <div class="rating">
                <label><input type="radio" name="assignments" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="assignments" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="assignments" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="assignments" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="assignments" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="feedback">8. how helpful is the professor's actionable feedback?</label>
            <div class="rating">
                <label><input type="radio" name="feedback" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="feedback" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="feedback" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="feedback" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="feedback" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="classTimeliness">9. Does the professor start and end classes on time consistently?</label>
            <div class="rating">
                <label><input type="radio" name="classTimeliness" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="classTimeliness" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="classTimeliness" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="classTimeliness" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="classTimeliness" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="academicGrowth">10. How much have you grown academically from this course?</label>
            <div class="rating">
                <label><input type="radio" name="academicGrowth" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="academicGrowth" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="academicGrowth" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="academicGrowth" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="academicGrowth" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <div class="question">
            <label for="recommendation">11. Would you recommend this professor to juniors?</label>
            <div class="rating">
                <label><input type="radio" name="recommendation" value="1" required ondblclick="deselectRadio(this)"> 1</label>
                <label><input type="radio" name="recommendation" value="2" ondblclick="deselectRadio(this)"> 2</label>
                <label><input type="radio" name="recommendation" value="3" ondblclick="deselectRadio(this)"> 3</label>
                <label><input type="radio" name="recommendation" value="4" ondblclick="deselectRadio(this)"> 4</label>
                <label><input type="radio" name="recommendation" value="5" ondblclick="deselectRadio(this)"> 5</label>
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
    <script>
        function deselectRadio(radioButton) {
            if (radioButton.checked) {
                radioButton.checked = false;
            }
        }
    </script>
</body>
</html>
