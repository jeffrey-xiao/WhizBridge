//
//  WhizLoginViewController.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import UIKit

class WhizLoginViewController: UIViewController, UITextFieldDelegate{

    @IBOutlet weak var userTextField: UITextField!
    @IBOutlet weak var passwordTextField: UITextField!
    var dataProvider = DataProvider()
    override func viewDidLoad() {
        super.viewDidLoad()
        userTextField.delegate = self
        passwordTextField.delegate = self
        
        var tap: UITapGestureRecognizer = UITapGestureRecognizer(target:self, action:Selector("dismissKeyboard"))
        view.addGestureRecognizer(tap)
        // Do any additional setup after loading the view.
    }
    
    override func viewDidDisappear(animated: Bool) {
        super.viewWillDisappear(animated)
        NSNotificationCenter.defaultCenter().removeObserver(self)
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func loginPressed(sender: AnyObject) {
        var user = userTextField.text
        var password = passwordTextField.text
        if(user.isEmpty || password.isEmpty) {
            displayErrorAlertMessage("uhoh")
            return
        }
        
        //prepare view for network call
        dismissKeyboard()
        
        //make data provider call
        dataProvider.login(user, password: password, completion: { status in
            if status == 1 {
                //set isUserLoggedIn bool to true
                NSUserDefaults.standardUserDefaults().setBool(true, forKey: "isUserLoggedIn")
                NSUserDefaults.standardUserDefaults().synchronize()
                
                //Show HomeTableView
               
                self.performSegueWithIdentifier("showWhizTabBar", sender: self)
                
                
            } else {
                self.displayErrorAlertMessage("uhoh")
            }
        })

    }
    
    func textFieldShouldReturn(textField: UITextField) -> Bool
    {
        textField.resignFirstResponder();
        return true;
    }
    
    func dismissKeyboard() {
        userTextField.resignFirstResponder()
        passwordTextField.resignFirstResponder()
        
        //println("tapped")
    }
    
    func displayErrorAlertMessage(message:String){
        var newAlert = UIAlertController(title: "Error", message: message, preferredStyle: UIAlertControllerStyle.Alert)
        let okAction = UIAlertAction(title:"Ok", style:UIAlertActionStyle.Default, handler:nil)
        newAlert.addAction(okAction)
        self.presentViewController(newAlert, animated:true, completion:nil)
    }

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
