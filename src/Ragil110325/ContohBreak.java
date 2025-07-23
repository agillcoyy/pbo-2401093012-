/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil110325;

/**
 *
 * @author Muhamad Soleh
 */
public class ContohBreak {
    public static void main(String[] args){
        String names[] = {"Beah", "Blanca", "Lance", "Belle", "Nico", "Yza", "Gem", "Ethan"};
        
        String searchName = "Yza";
        boolean foundName = false;
        
        for( int i=0; i< names.length; i++) {
            if ( names[i].equals (searchName)) {
                foundName = true;
                break;
            }
        }
        if (foundName) {
            System.out.println(searchName + "Found!");
        }
        else {
            System.out.println(searchName + "Not Found!");
        }
    }
}
