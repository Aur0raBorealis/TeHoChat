<fieldset class="center">
    <legend>
        <h1>
            Käyttäjätilin luonti
        </h1>
        </legend>
    <form method="post">
        <p>
            Puhelinnumero
            <br/> 
            <input id="phone" class="inpt" type="tel" name="givenPhoneNumber" maxlength="40" required />
        </p>
        <p>
            Käyttäjätunnus
            <br/> 
            <input class="inpt" type="text" name="givenUsername" maxlength="40" required />
        </p>
        <p>
            Salasana
            <br/>  
            <input class="inpt" type="password" name="givenPassword" maxlength="40" required />
        </p>
        <p>
            Salasanan vahvistus 
            <br/>  
            <input class="inpt" type="password" name="givenPasswordVerify" maxlength="40" required />
        </p>
        <p>
            <br/>  
            <input class="btn" type="submit" name="submitUser" value="Hyväksyä"/>
            <input class="btn" type="reset"  value="Tyhjennä"/>
            <input class="btn" type="submit" name="submitBack" value="Peruta"/>
        </p>
    </form>
</fieldset>