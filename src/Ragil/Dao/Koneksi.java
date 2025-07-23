
/**
 *
 * @author Muhamad Soleh
 */
package Ragil.Dao;

import java.sql.Connection;
import java.sql.DriverManager;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;

public class Koneksi {
    private final String url = "jdbc:mysql://localhost/PBO_2401093018";
    private final String username = "root";
    private final String password = "";
    
    public Connection getKoneksi()throws Exception {
        Class.forName("com.mysql.cj.jdbc.Driver");
        return DriverManager.getConnection(url, username, password);
    }
    
    public static void main(String[] args) {
        try {
            Koneksi k = new Koneksi();
            
            k.getKoneksi();
            JOptionPane.showMessageDialog(null, "Koneksi OK");
        } catch (Exception ex) {
            JOptionPane.showMessageDialog(null, "Error : "+ex.getMessage());
            Logger.getLogger(Koneksi.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }
}
