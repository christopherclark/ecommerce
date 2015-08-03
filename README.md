# ecommerce
*(PHP/CI/MySQL) ecommerce website, admin portal*

**Summary**

Given [these wireframes](assets/ecommerce-wireframes.png) as part of a school project in **PHP MVC**, three of us produced [this e-commerce website](http://52.11.100.130/) over the course of one week. I later forked it and deployed it myself on Amazon EC2. At this site, users are allowed to search for and buy products, and admins have their own portal to manage the orders and products in the database. For this ficticious storefront we chose a "horseshoes and hand grenades" theme to keep it fun, and H&H Supplies was born.

**Planning**

We tracked our high-level tasks with a simple app called [Trello](http://trello.com). We started by coding in HTML/CSS the several views that we needed, and over time these ended up becoming our long-term ownership roles on the project:
* user side - **me** ([GitHub](https://github.com/roderickwoodman)|[LinkedIn](https://www.linkedin.com/in/rodwoodman))
* admin side - **Paula Chojnacki** ([GitHub](https://github.com/prchojnacki)|[LinkedIn](https://www.linkedin.com/in/paulachojnacki))
* shopping cart and database - **Chris Clark** ([GitHub](https://github.com/christopherclark)|[LinkedIn](https://www.linkedin.com/pub/chris-clark/32/638/382))

**Implementation**

We were able to work fairly independently on these areas, but we also came together to integrate via GitHub when needed. Many times this was simply to update our common database with some new product and orders data. 

Personally, I learned how to use **Amazon S3** for storing images in the cloud, reducing the footprint of our database. But the most challenging (...and fun!) part was managing the state of the front-end. There were so many user inputs for filtering products:

1. dropdown for ordering results by price or popularity
2. search box for showing only matches to a product name substring
3. nav link for showing only matches to a product category
4. pagination buttons for showing only a practical number of products

At all times, the handful of products shown to the user needed to be based on input from each of these 4 filters. So I implemented hidden input tags to keep track of every filter's state, dynamically changing their values with PHP any time the user changed any filter. Then the back end MySQL queries were targeted to look up only the intersection of all of these filters. This implementation allowed the user to be able to stack filters, and the database only served up the products that were to be displayed.

Then when I deployed this website, I used **Amazon EC2** running Ubuntu. It was a bit of a hassle getting the proper configuration of credentials between Ubuntu/Apache and CodeIgniter files. Then once I got that working I created a "production" environment variable so that whether I'm running from localhost or from the cloud I don't have to change any config files, only the application source code in my GitHub repo. I also hid some files with private credentials in my .gitignore.

**Conclusion**

This project was clearly a success. We were one of only two teams who finished the week with a presentable project. I think this is because our team scoped the project size correctly and we planned out our tasks with priorities. We never ran into any of the code-rewriting or GitHub/merging headaches that other teams experienced. We had the right number of people and we worked well together. This was a very rewarding full-stack application.

