//
//  PostJobViewController.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import UIKit
import CoreLocation

class PostJobViewController: UIViewController {

    @IBOutlet weak var nameField: UITextField!
    @IBOutlet weak var descriptionField: UITextField!
    @IBOutlet weak var addressField: UITextField!
    @IBOutlet weak var priceField: UITextField!
    @IBOutlet weak var emailField: UITextField!
    @IBOutlet weak var cardNumberField: UITextField!
    @IBOutlet weak var expiryField: UITextField!
    @IBOutlet weak var cvvField: UITextField!
    @IBOutlet weak var postalField: UITextField!
    @IBOutlet weak var cardHolderField: UITextField!
    
    let dataProvider = DataProvider()
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func postButton(sender: AnyObject) {
        var address = addressField.text
        var geocoder = CLGeocoder()
        println("1")
        geocoder.geocodeAddressString(address, completionHandler: {(placemarks: [AnyObject]!, error: NSError!) -> Void in
            if let placemark = placemarks?[0] as? CLPlacemark {
                println("2")
                var lat = placemark.location.coordinate.latitude
                var long = placemark.location.coordinate.longitude
                println("2.5")
                self.dataProvider.postJob(self.nameField.text, description: self.descriptionField.text, address: self.addressField.text, price: self.priceField.text, email: self.emailField.text, cardNumber: self.cardNumberField.text, expiry: self.expiryField.text, cvv: self.cvvField.text, postal: self.postalField.text, cardHolder: self.cardHolderField.text, lat: lat, long: long) { resp in
                    println("3")
                    println(resp)
                    self.navigationController?.dismissViewControllerAnimated(true, completion: nil)
                }
            }
        })

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
