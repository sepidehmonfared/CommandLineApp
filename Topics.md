# LevelUp CommandLineApp Solution

I used decorator design pattern to solve this exercise.

I used Decorator pattern to construct complex text filtering rules
to clean up content before posting it on a web server. 
and i considered Different types of filters, such as XSSFilter, SpechialCharsFilter , ..
and you can use different sets of filters And this method can increase flexibility and changeability.

At the first i choosed the "Template Method" design pattern and wrote some filters class,
Each subclass represented a separate Filtering Method, 
but after a while i thought That's not what I wanted that's why 
i though about another structure that filters are able to complement each other and thus i decided to use decorator pattern

    i used https://designpatternsphp.readthedocs.io/en/latest/Structural/Decorator/README.html

I used Also PHPUnit For Testing