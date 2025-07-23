/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil060325;

/**
 *
 * @author Muhamad Soleh
 */
import java.io.*;
public class InputTugas4111 {
    public static void main(String[] args){
        BufferedReader dataIn =
            new BufferedReader (new InputStreamReader (System.in) );
       int number= 0;
       char letter = 'a';
       boolean result = true;
       String str = "", t = "";
        
        try {
            System.out.println("Enter Number = ");
            number = Integer.parseInt (dataIn.readLine());
            
            System.out.println("Enter Letter = ");
            t = dataIn.readLine();
            letter = t.charAt(0);
            
            System.out.println("Enter Str = ");
            str = dataIn.readLine();
        } catch ( IOException e ){
            System.out.println("Error in getting input");
        }
        System.out.println("number = "+number);
        System.out.println("letter = "+letter);
        System.out.println("result = "+result);
        System.out.println("str = "+str);
    }
}
