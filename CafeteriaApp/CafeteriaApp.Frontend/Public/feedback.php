<?php $x = rand(0, 20); $y = rand(0, 20);?>
<div class="background" ng-controller="feedback" ng-init="result=<?= ($y + $x); ?>">
    <div id="feedbackForm">
        <img src="../images/feedback/feed_back.jpg" style="position: absolute;left: 0;top: 0;width: 100%;height: 100%;opacity: 0.5;z-index: -1">
            <form action="feedback form.php" method="post">
                <div class="entry">
                    <label for="name">
                        Name
                    </label>
                    <input id="name" ng-model="name" required="" type="text"/>
                </div>
                <div class="entry">
                    <label for="mail">
                        Email
                    </label>
                    <input id="mail" ng-model="mail" required="" type="mail"/>
                </div>
                <div class="entry">
                    <label for="phone">
                        Phone
                    </label>
                    <input id="phone" ng-model="phone" required="" type="text"/>
                </div>
                <div class="entry">
                    <label for="about">
                        About
                    </label>
                    <select id="about" ng-model="selectedAbout" ng-options="a.Name for a in abouts">
                    </select>
                </div>
                <div class="entry">
                    <h4 style="margin: 0px;padding-left: 50px;color: red">
                        <?php echo $x ; ?>
                        +
                        <?php echo $y;?>
                        =
                    </h4>
                    <label for="check" style="float: left">
                        Answer
                    </label>
                    <input id="check" name="check" ng-model="answer" required="" type="text"/>
                </div>
                <div class="entry">
                    <label for="message" style="float: left">
                        Message
                    </label>
                    <textarea id="message" ng-model="message" required="">
                    </textarea>
                </div>
                <input class="btn btn-info btn-lg" id="submitbtn" name="submit" ng-click="addFeedback(name, mail, phone, selectedAbout, message, answer)" type="submit" value="Submit"/>
                <h4 ng-cloak="" ng-show="success" style="color: yellow">
                    Thanks, your feedback has submitted !
                </h4>
                <h4 ng-cloak="" ng-show="failure" style="color: red">
                    Sorry, we couldn't get your feedback .try later.
                </h4>
                <h4 ng-cloak="" ng-show="SummationWrong" style="color: red">
                    Summation is wrong, try again.
                </h4>
            </form>
        </img>
    </div>
</div>
<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/js/feedback.js">
</script>