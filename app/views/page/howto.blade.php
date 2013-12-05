@extends('layout/layout')
@section('content')
<div class="row">
    <div class="col-md-11">
        <h2>The philosophy behind it</h2>
        <p>Because I couldn't find a simple web app for managing my 
            personal finances I created one myself. I know there are a 
            lot of them these days but I wanted something <strong>really simple</strong>, 
            without useless charts and other mambo-jumbos. All I wanted was 
            to know how much can I spend in a period of time, and how much 
            money I have at a given time. So after making a pattern in my 
            Google spreadsheets I decided to create my custom web app.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Start by creating a tablet</h3>
        <p>A tablet is a <strong>personal budget</strong>. It's up to you on what period of 
            time you decide to use it. All you need to add is your 
            current income and economies if any. A tablet is currency agnostic, 
            you can have only one active and you can close it any time.
        </p>
    </div>
    <div class="col-md-4" style="margin-top: 30px;">        
        <img class="thumbnail" src="/img/create-tablet.png" alt="create-tablet" />
    </div>
</div>
<div class="row">
    <div class="col-md-6">        
        <h3>Add your predictions</h3>
        <p>After creating your tablet you start adding your predictions. 
            In other words, your <strong>future spendings</strong> during this tablet. 
            With each prediction added you will see that the Balance will 
            decrease. Balance is how much money you will have after spending 
            all those predictions.
        </p>
    </div>
    <div class="col-md-4" style="margin-top: 30px;">        
        <img class="thumbnail" src="/img/create-prediction.png" alt="create-prediction" />
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Add your expenses</h3>
        <p>After adding your predictions you can start spending. You will 
            see that your current money will decrease with each spending 
            and also each prediction budget.
        </p>
    </div>
    <div class="col-md-4" style="margin-top: 30px;">        
        <img class="thumbnail" src="/img/add-expense.png" alt="add-expense" />
    </div>
</div>
<div class="row">
    <div class="col-md-11">
        <h3>The main goal</h3>
        <p>The main goal of this application is to know how much money 
            you have at any given time and how much money you can spend 
            without going bellow your means. Watch your <strong>Balance</strong> value and 
            don't let it drop bellow zero. Happy spendings!
        </p>
    </div>
</div>
@stop
