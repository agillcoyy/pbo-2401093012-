/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil040325;

/**
 *
 * @author Muhamad Soleh
 */
public class OperatorKondisi {
    public static void main(String[] args) {
        String status = "";
        int grade = 80;
        
        //mendapatkan status pelajar
        status = (grade >= 60)?"Passed":"Fail";
        
        //print status
        System.out.println( status );
        
        int score = 0;
        char answer = 'a';
        
        score = (answer == 'a') ? 10 : 0;
        System.out.println("Score = "+score);
    }
}
