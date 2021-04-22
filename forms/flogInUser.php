<div class="center" id="logInForm">
    <fieldset>
        <legend class="center">
            Kirjaudu sisään
        </legend>
        <form method="post">
            <p>
                Käyttäjätunnuns 
                <br/>
                <input type="text" name="givenUsername" maxlength="40" required/>
            </p>
            <p>
                Salasana
                <br/>
                <input type="password" name="givenPassword" maxlength="40" required/>
            </p>
            <p>
                <br/>
                <input class="btn" type="submit" name="submitUser" value="Submit"/>
                <input type="reset"  value="Tyhjennä"/>
                <input class="btn cencel" onClick="closeForm" type="submit" name="submitBack" value="Peruta"/>
            </p>
        </form>
    </fieldset>
</div>
