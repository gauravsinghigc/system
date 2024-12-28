# system
 Here’s the installation process for **GSI Framework v1.0**:

---

### **Installation Steps for GSI Framework v1.0**

1. **Download and Extract**  
   - Download the ZIP file from the official repository:  
     [https://github.com/gauravsinghigc/system/archive/refs/tags/GSI_Framework_v1.0.zip](https://github.com/gauravsinghigc/system/archive/refs/tags/GSI_Framework_v1.0.zip)  
   - Extract the downloaded ZIP file to a desired location on your system.

2. **Open in Your IDE**  
   - Use an IDE of your choice, such as **VS Code**, **Sublime Text**, or others, to open the extracted project files.

3. **Edit the Configuration**  
   - Locate the `config.php` file in the root directory of the project.  
   - Update the following:
     - Add your local IP address.
     - Set the path of the extracted folder. Ensure the project resides in a valid server directory like `C:/xampp/htdocs` (or the equivalent directory in your server setup).

4. **Create a Database**  
   - Open **phpMyAdmin** in your browser.  
   - Create a fresh database for the project.  
   - Add the database name, username, and password to the **Database connection constants** in the `config.php` file.

5. **Run the Project**  
   - Open your browser and navigate to the project URL (e.g., `http://localhost/<your-folder-name>`).  
   - On the first load, you may encounter errors. Append the following query string to the URL in your browser:  
     ```
     ?sys_sql=Gsi@dmy
     ```
     Replace **dmy** with:
     - `d` = Current date  
     - `m` = Current month  
     - `y` = Current year  
     *(For example, if today’s date is December 28, 2024, the query would be `?sys_sql=Gsi@281224`.)*  
   - Press **Enter**. This action will import the primary database required for the project.

6. **Verify Database Import**  
   - Upon successful database import, the login page will appear.

7. **Login to the System**  
   - Use the following primary login credentials:  
     - **Username**: `gauravsinghigc@gmail.com`  
     - **Password**: `Gsi@9810`  
   - The login page includes features such as password reset, authentication validation, and regeneration options.

8. **Installation Complete**  
   - Congratulations! You have successfully installed the GSI CRM. Start exploring the features and functionalities.

--- 

Let me know if you need further clarifications or assistance!
