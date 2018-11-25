$(document).ready(function(){
    //initialize objects
    var display = new Display();
    var configuration = new Configuration();
    var databaseControl = new DatabaseControl();


    //submit search query
    $("#").submit(function(){
        //get search value
        var search = $("#").val();
        //query database
        var results = databaseControl.search(search);
        //get number of results per page
        var numPerPage = configuration.getResultsPerPage();
        //display results
        display.displayResults(results, numPerPage);

        
    });

    //submit change to configuration
    $("#").submit(function(){
        
    });

    //submit KWIC indexing
    $("#").submit(function(){
        
    });
});