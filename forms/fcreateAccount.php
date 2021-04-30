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
            <input id="phone" type="tel" name="givenPhoneNumber" maxlength="40" required />
        </p>
        <p>
            Käyttäjätunnus
            <br/> 
            <input type="text" name="givenUsername" maxlength="40" required />
        </p>
        <p>
            Salasana
            <br/>  
            <input type="password" name="givenPassword" maxlength="40" required />
        </p>
        <p>
            Salasanan vahvistus 
            <br/>  
            <input type="password" name="givenPasswordVerify" maxlength="40" required />
        </p>
        <p>
            <br/>  
            <input type="submit" name="submitUser" value="Submit"/>
            <input type="reset"  value="Reset"/>
            <input type="submit" name="submitBack" value="Pääsivulle"/>
        </p>
    </form>
</fieldset>